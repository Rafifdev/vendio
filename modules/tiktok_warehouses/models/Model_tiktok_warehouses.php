<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_tiktok_warehouses extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'tiktok_warehouses';
    private $field_search   = ['shop_id', 'tiktok_warehouse_id', 'branch_mapping_id', 'name', 'address', 'warehouse_type', 'effect_status', 'is_default', 'created_at', 'updated_at'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
         );

        parent::__construct($config);
    }

    public function count_all($q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);

        if (empty($field)) {
            foreach ($this->field_search as $field) {
                if ($iterasi == 1) {
                    $where .= "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_warehouses.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
                $this->db->order_by('tiktok_warehouses.'.$this->primary_key, "DESC");
                $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        
        $this->db->select('tiktok_warehouses.*');


        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            }

        return $this;
    }

}

/* End of file Model_tiktok_warehouses.php */
/* Location: ./application/models/Model_tiktok_warehouses.php */