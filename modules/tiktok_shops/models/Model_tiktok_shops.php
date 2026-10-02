<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_tiktok_shops extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'tiktok_shops';
    private $field_search   = ['shop_id', 'shop_name', 'shop_code', 'seller_name', 'seller_base_region', 'is_active'];

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
                    $where .= "tiktok_shops.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_shops.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_shops.".$field . " LIKE '%" . $q . "%' )";
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
                    $where .= "tiktok_shops.".$field . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . "tiktok_shops.".$field . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "tiktok_shops.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
                $this->db->order_by('tiktok_shops.'.$this->primary_key, "DESC");
                $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        
        $this->db->select('tiktok_shops.*');


        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            }

        return $this;
    }

    /**
     * Override standard remove to ensure cascade deletion across all modules
     *
     * @param int|null $id
     * @return bool
     */
    public function remove($id = NULL)
    {
        return $this->remove_cascade($id);
    }

    /**
     * Cascade delete all referenced data for a given shop
     *
     * @param int $id ID of tiktok_shops
     * @return bool
     */
    public function remove_cascade($id)
    {
        if (empty($id)) {
            return false;
        }

        $shop = $this->db->get_where($this->table_name, ['id' => $id])->row();
        if (!$shop) {
            return false;
        }

        $shop_id_int = (int) $shop->id;
        $shop_id_str = !empty($shop->shop_id) ? (string) $shop->shop_id : null;

        $this->db->trans_start();

        // 1. ORDERS & ORDER SUB-TABLES
        $orders = $this->db->select('id, order_id, package_id')
            ->where('tiktok_shop_id', $shop_id_int)
            ->get('tiktok_orders')
            ->result();

        if (!empty($orders)) {
            $order_db_ids = array_column($orders, 'id');
            $order_sn_ids = array_filter(array_column($orders, 'order_id'));
            $package_ids  = array_filter(array_column($orders, 'package_id'));

            if (!empty($order_db_ids)) {
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_items');
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_price_details');
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_status_logs');
            }
            if (!empty($order_sn_ids)) {
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_items');
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_price_details');
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_status_logs');
            }
            if (!empty($package_ids)) {
                $this->db->where_in('package_id', $package_ids)->delete('tiktok_shipping_documents');
            }

            $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_orders');
        }

        // 2. PRODUCTS & PRODUCT SKUS
        $products = $this->db->select('id, product_id')
            ->where('tiktok_shop_id', $shop_id_int)
            ->get('tiktok_products')
            ->result();

        if (!empty($products)) {
            $prod_db_ids     = array_column($products, 'id');
            $prod_tiktok_ids = array_filter(array_column($products, 'product_id'));

            if (!empty($prod_db_ids)) {
                $this->db->where_in('tiktok_product_id', $prod_db_ids)->delete('tiktok_product_skus');
            }
            if (!empty($prod_tiktok_ids)) {
                $this->db->where_in('product_id', $prod_tiktok_ids)->delete('tiktok_product_skus');
            }

            $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_products');
        }

        // 3. PRODUCT SYNC LOGS
        $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_product_sync_logs');

        // 4. CANCELLATIONS
        $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_cancellations');

        // 5. RETURNS
        $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_returns');

        // 6. FINANCE & STATEMENT TRANSACTIONS
        $finances = $this->db->select('id, statement_id')
            ->where('tiktok_shop_id', $shop_id_int)
            ->get('tiktok_finance')
            ->result();

        if (!empty($finances)) {
            $fin_db_ids    = array_column($finances, 'id');
            $statement_ids = array_filter(array_column($finances, 'statement_id'));

            if (!empty($fin_db_ids)) {
                $this->db->where_in('tiktok_finance_id', $fin_db_ids)->delete('tiktok_statement_transactions');
            }
            if (!empty($statement_ids)) {
                $this->db->where_in('statement_id', $statement_ids)->delete('tiktok_statement_transactions');
            }

            $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_finance');
        }

        // 7. UNSETTLED TRANSACTIONS & WITHDRAWALS
        $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_unsettled_transactions');
        $this->db->where('tiktok_shop_id', $shop_id_int)->delete('tiktok_withdrawals');

        // 8. WAREHOUSES & DELIVERY OPTIONS & SHIPPING PROVIDERS
        $this->db->group_start()->where('shop_id', $shop_id_int);
        if (!empty($shop_id_str)) {
            $this->db->or_where('shop_id', $shop_id_str);
        }
        $this->db->group_end();
        $warehouses = $this->db->select('id')->get('tiktok_warehouses')->result();

        if (!empty($warehouses)) {
            $wh_ids = array_column($warehouses, 'id');
            $del_options = $this->db->select('id')->where_in('warehouse_id', $wh_ids)->get('tiktok_delivery_options')->result();
            if (!empty($del_options)) {
                $del_ids = array_column($del_options, 'id');
                $this->db->where_in('delivery_option_id', $del_ids)->delete('tiktok_shipping_providers');
                $this->db->where_in('id', $del_ids)->delete('tiktok_delivery_options');
            }

            $this->db->group_start()->where('shop_id', $shop_id_int);
            if (!empty($shop_id_str)) {
                $this->db->or_where('shop_id', $shop_id_str);
            }
            $this->db->group_end();
            $this->db->delete('tiktok_warehouses');
        }

        // 9. OAUTH STATES & API LOGS
        $this->db->group_start()->where('shop_id', $shop_id_int);
        if (!empty($shop_id_str)) {
            $this->db->or_where('shop_id', $shop_id_str);
        }
        $this->db->group_end();
        $this->db->delete('tiktok_oauth_states');

        $this->db->group_start()->where('shop_id', $shop_id_int);
        if (!empty($shop_id_str)) {
            $this->db->or_where('shop_id', $shop_id_str);
        }
        $this->db->group_end();
        $this->db->delete('tiktok_api_logs');

        // 10. DELETE SHOP RECORD
        $this->db->where('id', $shop_id_int)->delete($this->table_name);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Clean up any orphaned records referencing shops that no longer exist
     */
    public function clean_orphaned_records()
    {
        $active_shops = $this->db->select('id, shop_id')->get($this->table_name)->result_array();
        $active_ids = array_column($active_shops, 'id');
        $active_shop_ids_str = array_filter(array_column($active_shops, 'shop_id'));

        if (empty($active_ids)) {
            return;
        }

        // 1. Orphan Orders
        $orphan_orders = $this->db->select('id, order_id, package_id')
            ->where_not_in('tiktok_shop_id', $active_ids)
            ->get('tiktok_orders')
            ->result();

        if (!empty($orphan_orders)) {
            $order_db_ids = array_column($orphan_orders, 'id');
            $order_sn_ids = array_filter(array_column($orphan_orders, 'order_id'));
            $package_ids  = array_filter(array_column($orphan_orders, 'package_id'));

            if (!empty($order_db_ids)) {
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_items');
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_price_details');
                $this->db->where_in('tiktok_order_id', $order_db_ids)->delete('tiktok_order_status_logs');
                $this->db->where_in('id', $order_db_ids)->delete('tiktok_orders');
            }
            if (!empty($order_sn_ids)) {
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_items');
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_price_details');
                $this->db->where_in('order_id', $order_sn_ids)->delete('tiktok_order_status_logs');
            }
            if (!empty($package_ids)) {
                $this->db->where_in('package_id', $package_ids)->delete('tiktok_shipping_documents');
            }
        }

        // 2. Orphan Products
        $orphan_products = $this->db->select('id, product_id')
            ->where_not_in('tiktok_shop_id', $active_ids)
            ->get('tiktok_products')
            ->result();

        if (!empty($orphan_products)) {
            $prod_db_ids = array_column($orphan_products, 'id');
            $prod_sn_ids = array_filter(array_column($orphan_products, 'product_id'));

            if (!empty($prod_db_ids)) {
                $this->db->where_in('tiktok_product_id', $prod_db_ids)->delete('tiktok_product_skus');
                $this->db->where_in('id', $prod_db_ids)->delete('tiktok_products');
            }
            if (!empty($prod_sn_ids)) {
                $this->db->where_in('product_id', $prod_sn_ids)->delete('tiktok_product_skus');
            }
        }

        $this->db->where_not_in('tiktok_shop_id', $active_ids)->delete('tiktok_product_sync_logs');
        $this->db->where_not_in('tiktok_shop_id', $active_ids)->delete('tiktok_cancellations');
        $this->db->where_not_in('tiktok_shop_id', $active_ids)->delete('tiktok_returns');
        $this->db->where_not_in('tiktok_shop_id', $active_ids)->delete('tiktok_unsettled_transactions');
        $this->db->where_not_in('tiktok_shop_id', $active_ids)->delete('tiktok_withdrawals');

        // 3. Orphan Finance
        $orphan_finances = $this->db->select('id, statement_id')
            ->where_not_in('tiktok_shop_id', $active_ids)
            ->get('tiktok_finance')
            ->result();

        if (!empty($orphan_finances)) {
            $fin_db_ids = array_column($orphan_finances, 'id');
            $fin_sn_ids = array_filter(array_column($orphan_finances, 'statement_id'));

            if (!empty($fin_db_ids)) {
                $this->db->where_in('tiktok_finance_id', $fin_db_ids)->delete('tiktok_statement_transactions');
                $this->db->where_in('id', $fin_db_ids)->delete('tiktok_finance');
            }
            if (!empty($fin_sn_ids)) {
                $this->db->where_in('statement_id', $fin_sn_ids)->delete('tiktok_statement_transactions');
            }
        }

        // 4. Orphan Warehouses & Delivery Options
        $all_valid_shop_identifiers = array_merge($active_ids, $active_shop_ids_str);
        if (!empty($all_valid_shop_identifiers)) {
            $orphan_warehouses = $this->db->select('id')
                ->where_not_in('shop_id', $all_valid_shop_identifiers)
                ->get('tiktok_warehouses')
                ->result();

            if (!empty($orphan_warehouses)) {
                $wh_ids = array_column($orphan_warehouses, 'id');
                $del_opts = $this->db->select('id')->where_in('warehouse_id', $wh_ids)->get('tiktok_delivery_options')->result();
                if (!empty($del_opts)) {
                    $del_ids = array_column($del_opts, 'id');
                    $this->db->where_in('delivery_option_id', $del_ids)->delete('tiktok_shipping_providers');
                    $this->db->where_in('id', $del_ids)->delete('tiktok_delivery_options');
                }
                $this->db->where_in('id', $wh_ids)->delete('tiktok_warehouses');
            }

            $this->db->where_not_in('shop_id', $all_valid_shop_identifiers)->delete('tiktok_api_logs');
        }
    }
}

/* End of file Model_tiktok_shops.php */
/* Location: ./application/models/Model_tiktok_shops.php */