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
            'perlu'      => ['AWAITING_SHIPMENT'],
            'belum'      => ['UNPAID'],
            'bayar'      => ['UNPAID'],
            'tahan'      => ['ON_HOLD'],
            'ditahan'    => ['ON_HOLD'],
            'jemput'     => ['AWAITING_COLLECTION'],
            'kurir'      => ['AWAITING_COLLECTION'],
            'kirim'      => ['AWAITING_SHIPMENT', 'IN_TRANSIT', 'PARTIALLY_SHIPPING'],
            'dikirim'    => ['IN_TRANSIT'],
            'terkirim'   => ['DELIVERED'],
            'sampai'     => ['DELIVERED'],
            'selesai'    => ['COMPLETED', 'DELIVERED'],
            'batal'      => ['CANCELLED'],
            'gagal'      => ['DELIVERY_FAILED', 'UNDELIVERED', 'FAILED'],
            'proses'     => ['ON_HOLD', 'UNPAID', 'PROCESSING'],
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

    public function apply_status_filter($status = null)
    {
        if ($status === null) {
            $status = $this->input->get('status');
        }

        if (empty($status) || strtoupper($status) === 'ALL') {
            return $this;
        }

        $st = strtoupper(trim((string)$status));
        switch ($st) {
            case 'AWAITING_SHIPMENT':
            case 'TO_SHIP':
                $this->db->where_in('tiktok_orders.order_status', ['AWAITING_SHIPMENT', 'AWAITING_COLLECTION']);
                break;
            case 'IN_TRANSIT':
            case 'SHIPPED':
                $this->db->where_in('tiktok_orders.order_status', ['IN_TRANSIT', 'PARTIALLY_SHIPPING']);
                break;
            case 'COMPLETED':
                $this->db->where_in('tiktok_orders.order_status', ['COMPLETED', 'DELIVERED']);
                break;
            case 'IN_PROCESS':
            case 'PROCESSING':
            case 'UNPAID':
            case 'ON_HOLD':
                $this->db->where_in('tiktok_orders.order_status', ['UNPAID', 'ON_HOLD', 'PROCESSING']);
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
                $this->db->where('tiktok_orders.order_status', $st);
                break;
        }

        return $this;
    }

    public function count_all($q = null, $field = null, $shop_id = null, $order_status = null)
    {
        $where = $this->_build_search_condition($q, $field);

        $this->join_avaiable()->filter_avaiable($shop_id, $order_status);
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [], $shop_id = null, $order_status = null)
    {
        $where = $this->_build_search_condition($q, $field);

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable($shop_id, $order_status);
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

    public function filter_avaiable($shop_id = null, $order_status = null) {
        if (!$this->aauth->is_admin()) {
        }

        if ($order_status === null) {
            $order_status = $this->input->get('status');
        }
        $this->apply_status_filter($order_status);

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