<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_tiktok_packages extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'tiktok_packages';
    private $field_search   = ['tiktok_shop_id', 'package_id', 'order_id', 'package_status', 'package_sub_status', 'shipping_provider_id', 'shipping_provider_name', 'shipping_type', 'delivery_option_id', 'delivery_option_name', 'tracking_number', 'handover_method', 'dimension_length', 'dimension_width', 'dimension_height', 'dimension_unit', 'weight_val', 'weight_unit', 'sender_name', 'sender_phone', 'sender_address', 'recipient_name', 'recipient_phone', 'recipient_address', 'package_create_time', 'package_update_time'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
         );

        parent::__construct($config);
    }

    public function count_all($q = null, $field = null, $shop_id = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_packages.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_packages.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_packages.".$field . " LIKE '%" . $q . "%' )";
        }

        if (!empty($shop_id)) {
            $this->db->where('tiktok_packages.tiktok_shop_id', $shop_id);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [], $shop_id = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_packages.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_packages.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_packages.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }

        if (!empty($shop_id)) {
            $this->db->where('tiktok_packages.tiktok_shop_id', $shop_id);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        $this->db->order_by('tiktok_packages.'.$this->primary_key, "DESC");
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        $this->db->select('tiktok_packages.*, tiktok_shops.shop_name as tiktok_shops_shop_name');
        $this->db->join('tiktok_shops', 'tiktok_shops.id = tiktok_packages.tiktok_shop_id', 'LEFT');

        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            }

        return $this;
    }

}

/* End of file Model_tiktok_packages.php */
/* Location: ./application/models/Model_tiktok_packages.php */