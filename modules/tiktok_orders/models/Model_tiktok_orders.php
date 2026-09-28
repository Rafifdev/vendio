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

    public function count_all($q = null, $field = null, $shop_id = null, $order_status = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_orders.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_orders.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_orders.".$field . " LIKE '%" . $q . "%' )";
        }

        if (!empty($shop_id)) {
            $this->db->where('tiktok_orders.tiktok_shop_id', $shop_id);
        }
        if (!empty($order_status)) {
            if ($order_status === 'COMPLETED') {
                $this->db->where_in('tiktok_orders.order_status', ['DELIVERED', 'COMPLETED']);
            } else {
                $this->db->where('tiktok_orders.order_status', $order_status);
            }
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [], $shop_id = null, $order_status = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_orders.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_orders.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_orders.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }

        if (!empty($shop_id)) {
            $this->db->where('tiktok_orders.tiktok_shop_id', $shop_id);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
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

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
        }

        $status = $this->input->get('status');
        if (!empty($status) && $status !== 'ALL') {
            $this->db->where('tiktok_orders.order_status', $status);
        }

        $shop_id = $this->input->get('shop_id');
        if (!empty($shop_id)) {
            $this->db->where('tiktok_orders.tiktok_shop_id', $shop_id);
        }

        return $this;
    }

}

/* End of file Model_tiktok_orders.php */
/* Location: ./application/models/Model_tiktok_orders.php */