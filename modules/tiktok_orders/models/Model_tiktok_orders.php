<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_tiktok_orders extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'tiktok_orders';
    private $field_search   = ['tiktok_shop_id', 'order_id', 'order_status', 'recipient_name', 'shipping_provider', 'shipping_type', 'delivery_option_name', 'tracking_number', 'total_amount', 'order_created_time'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
         );

        parent::__construct($config);
    }

    private function _build_search_condition($q, $field)
    {
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if ($q === null || $q === '') {
            return NULL;
        }

        // Map kata kunci pencarian status bahasa Indonesia ke kode status internal
        $status_keywords = [
            'perlu'        => ['AWAITING_SHIPMENT', 'AWAITING_COLLECTION'],
            'menunggu'     => ['AWAITING_SHIPMENT', 'AWAITING_COLLECTION'],
            'pengiriman'   => ['AWAITING_SHIPMENT', 'IN_TRANSIT'],
            'belum'        => ['UNPAID'],
            'bayar'        => ['UNPAID'],
            'dibayar'      => ['UNPAID'],
            'tahan'        => ['ON_HOLD'],
            'ditahan'      => ['ON_HOLD'],
            'jemput'       => ['AWAITING_COLLECTION'],
            'ambil'        => ['AWAITING_COLLECTION'],
            'pengambilan'  => ['AWAITING_COLLECTION'],
            'kurir'        => ['AWAITING_COLLECTION'],
            'kirim'        => ['AWAITING_SHIPMENT', 'IN_TRANSIT', 'PARTIALLY_SHIPPING', 'SHIPPED', 'DELIVERED'],
            'dikirim'      => ['IN_TRANSIT', 'SHIPPED', 'PARTIALLY_SHIPPING'],
            'transit'      => ['IN_TRANSIT'],
            'sedang transit' => ['IN_TRANSIT'],
            'terkirim'     => ['DELIVERED'],
            'sampai'       => ['DELIVERED'],
            'selesai'      => ['COMPLETED'],
            'batal'        => ['CANCELLED'],
            'dibatalkan'   => ['CANCELLED'],
            'gagal'        => ['DELIVERY_FAILED', 'UNDELIVERED', 'FAILED'],
            'proses'       => ['ON_HOLD', 'UNPAID', 'PROCESSING'],
            'dalam proses' => ['ON_HOLD', 'PROCESSING'],
        ];

        $matched_status_codes = [];
        $q_lower = strtolower(trim((string)$q));
        foreach ($status_keywords as $keyword => $codes) {
            if (strpos($q_lower, $keyword) !== false) {
                $matched_status_codes = array_merge($matched_status_codes, $codes);
            }
        }
        $matched_status_codes = array_unique($matched_status_codes);

        if (empty($field)) {
            $iterasi = 1;
            foreach ($this->field_search as $f) {
                if ($iterasi == 1) {
                    $where .= "tiktok_orders.".$f . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_orders.".$f . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            if (!empty($matched_status_codes)) {
                $status_in_sql = "'" . implode("','", array_map('addslashes', $matched_status_codes)) . "'";
                $where .= " OR tiktok_orders.order_status IN (" . $status_in_sql . ")";
            }

            $where = '('.$where.')';
        } else {
            if ($field === 'order_status' && !empty($matched_status_codes)) {
                $status_in_sql = "'" . implode("','", array_map('addslashes', $matched_status_codes)) . "'";
                $where = "(tiktok_orders.order_status LIKE '%" . $q . "%' OR tiktok_orders.order_status IN (" . $status_in_sql . "))";
            } else {
                $where = "(tiktok_orders.".$field . " LIKE '%" . $q . "%' )";
            }
        }

        return $where;
    }

    public function apply_status_filter($tab = null, $substatus = null, $order_status = null)
    {
        if ($tab === null) {
            $tab = $this->input->get('tab');
        }
        if ($substatus === null) {
            $substatus = $this->input->get('substatus');
        }
        if ($order_status === null) {
            $order_status = $this->input->get('status');
        }

        // Resolving fallback jika tab belum terisi tapi status lama ada
        if (empty($tab) && !empty($order_status)) {
            $st_fallback = strtoupper(trim((string)$order_status));
            if ($st_fallback === 'AWAITING_COLLECTION') {
                $tab = 'AWAITING_SHIPMENT';
                $substatus = 'AWAITING_COLLECTION';
            } elseif ($st_fallback === 'DELIVERED') {
                $tab = 'IN_TRANSIT';
                $substatus = 'DELIVERED';
            } elseif ($st_fallback === 'ON_HOLD') {
                $tab = 'IN_PROCESS';
                $substatus = 'ON_HOLD';
            } elseif (in_array($st_fallback, ['IN_PROCESS', 'PROCESSING', 'UNPAID'])) {
                $tab = 'IN_PROCESS';
            } else {
                $tab = $st_fallback;
            }
        }

        $tab = strtoupper(trim((string)$tab));
        $sub = strtoupper(trim((string)$substatus));

        // 1. Jika ada substatus spesifik yang dipilih dan bukan 'ALL'
        if (!empty($sub) && $sub !== 'ALL') {
            switch ($sub) {
                case 'AWAITING_SHIPMENT':
                    $this->db->where('tiktok_orders.order_status', 'AWAITING_SHIPMENT');
                    return $this;
                case 'AWAITING_COLLECTION':
                    $this->db->where('tiktok_orders.order_status', 'AWAITING_COLLECTION');
                    return $this;
                case 'IN_TRANSIT':
                    $this->db->where_in('tiktok_orders.order_status', ['IN_TRANSIT', 'SHIPPED', 'PARTIALLY_SHIPPING']);
                    return $this;
                case 'DELIVERED':
                    $this->db->where('tiktok_orders.order_status', 'DELIVERED');
                    return $this;
                case 'UNPAID':
                    $this->db->where('tiktok_orders.order_status', 'UNPAID');
                    return $this;
                case 'ON_HOLD':
                case 'IN_PROCESS':
                    $this->db->where_in('tiktok_orders.order_status', ['ON_HOLD', 'PROCESSING']);
                    return $this;
                default:
                    $this->db->where('tiktok_orders.order_status', $sub);
                    return $this;
            }
        }

        // 2. Jika tidak ada substatus spesifik, gunakan filter kategori Tab utama Seller Center
        if (empty($tab) || $tab === 'ALL') {
            return $this;
        }

        switch ($tab) {
            case 'IN_PROCESS':
            case 'PROCESSING':
            case 'ON_HOLD':
            case 'UNPAID':
                $this->db->where_in('tiktok_orders.order_status', ['ON_HOLD', 'UNPAID', 'PROCESSING']);
                break;
            case 'AWAITING_SHIPMENT':
            case 'TO_SHIP':
                $this->db->where_in('tiktok_orders.order_status', ['AWAITING_SHIPMENT', 'AWAITING_COLLECTION']);
                break;
            case 'IN_TRANSIT':
            case 'SHIPPED':
                // Di Seller Center, tab "Dikirim" mencakup status Dalam Pengiriman & Terkirim
                $this->db->where_in('tiktok_orders.order_status', ['IN_TRANSIT', 'PARTIALLY_SHIPPING', 'SHIPPED', 'DELIVERED']);
                break;
            case 'COMPLETED':
                $this->db->where('tiktok_orders.order_status', 'COMPLETED');
                break;
            case 'CANCELLED':
                $this->db->where('tiktok_orders.order_status', 'CANCELLED');
                break;
            case 'DELIVERY_FAILED':
            case 'UNDELIVERED':
            case 'FAILED':
                $this->db->where_in('tiktok_orders.order_status', ['DELIVERY_FAILED', 'UNDELIVERED', 'FAILED']);
                break;
            default:
                $this->db->where('tiktok_orders.order_status', $tab);
                break;
        }

        return $this;
    }

    public function count_all($q = null, $field = null, $shop_id = null, $order_status = null, $tab = null, $substatus = null)
    {
        $where = $this->_build_search_condition($q, $field);

        $this->join_avaiable()->filter_avaiable($shop_id, $order_status, $tab, $substatus);
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [], $shop_id = null, $order_status = null, $tab = null, $substatus = null)
    {
        $where = $this->_build_search_condition($q, $field);

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable($shop_id, $order_status, $tab, $substatus);
        if ($where) {
            $this->db->where($where);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('tiktok_orders.'.$this->primary_key, "DESC");
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        $this->db->join('tiktok_shops', 'tiktok_shops.id = tiktok_orders.tiktok_shop_id', 'LEFT');
        $this->db->select('tiktok_orders.*,tiktok_shops.shop_name as tiktok_shops_shop_name');

        return $this;
    }

    public function filter_avaiable($shop_id = null, $order_status = null, $tab = null, $substatus = null) {
        if (!$this->aauth->is_admin()) {
        }

        if ($tab === null) {
            $tab = $this->input->get('tab');
        }
        if ($substatus === null) {
            $substatus = $this->input->get('substatus');
        }
        if ($order_status === null) {
            $order_status = $this->input->get('status');
        }
        $this->apply_status_filter($tab, $substatus, $order_status);

        if ($shop_id === null) {
            $shop_id = $this->input->get('shop_id');
        }
        if (!empty($shop_id)) {
            $this->db->where('tiktok_orders.tiktok_shop_id', $shop_id);
        }

        return $this;
    }

}

/* End of file Model_tiktok_orders.php */
/* Location: ./application/models/Model_tiktok_orders.php */