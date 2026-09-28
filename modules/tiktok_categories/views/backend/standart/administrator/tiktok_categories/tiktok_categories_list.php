<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Tiktok_categories/add';
       return false;
   });

   $('*').bind('keydown', 'Ctrl+f', function assets() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {
       $('#reset').trigger('click');
       return false;
   });
}

jQuery(document).ready(domo);
</script>

<!-- Refined Minimalist Styling (Consistent with Akun Toko) -->
<style>
/* Main Card Wrapper */
.box-tiktok-categories {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

/* Header with Generous & Balanced Spacing */
.box-tiktok-categories .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-categories .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-categories .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-categories .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-categories .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-categories .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-categories .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-categories .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-categories .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-categories .btn-top-action {
   height: 34px !important;
   padding: 0 14px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   border-radius: 4px !important;
   background-color: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
   display: inline-flex !important;
   align-items: center !important;
   gap: 6px !important;
   transition: all 0.15s ease;
}

.box-tiktok-categories .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-categories .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}

.box-tiktok-categories .table-minimal {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-categories .table-minimal thead th {
   background-color: #f8fafc;
   color: #64748b;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.04em;
   border-top: none;
   border-bottom: 2px solid #e2e8f0;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   vertical-align: middle;
}

.box-tiktok-categories .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-categories .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

/* Subtle Column Chips & Tags */
.chip-id {
   font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
   font-size: 12px;
   color: #475569;
   background: #f1f5f9;
   padding: 3px 8px;
   border-radius: 4px;
   border: 1px solid #e2e8f0;
   display: inline-block;
}

.chip-tag {
   display: inline-block;
   padding: 2px 8px;
   border-radius: 4px;
   font-weight: 600;
   font-size: 11px;
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   color: #334155;
}

/* Soft Modern Status Badges */
.badge-status-pill {
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 3px 10px;
   border-radius: 12px;
   font-size: 11px;
   font-weight: 600;
}

.badge-status-active {
   background-color: #ecfdf5;
   color: #059669;
   border: 1px solid #a7f3d0;
}

.badge-status-warning {
   background-color: #fffbeb;
   color: #d97706;
   border: 1px solid #fde68a;
}

.status-dot {
   width: 6px;
   height: 6px;
   border-radius: 50%;
   display: inline-block;
}

.badge-status-active .status-dot {
   background-color: #10b981;
}

.badge-status-warning .status-dot {
   background-color: #f59e0b;
}

/* Action Links: Keep on 1 single line with clean gaps */
.action-buttons-wrap {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   white-space: nowrap;
}

.action-link {
   display: inline-flex !important;
   align-items: center !important;
   gap: 5px !important;
   padding: 4px 10px !important;
   height: 28px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 500 !important;
   color: #334155 !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   text-decoration: none !important;
   transition: all 0.15s ease !important;
   white-space: nowrap !important;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
}

.action-link i {
   font-size: 12px !important;
   color: #64748b !important;
   transition: color 0.15s ease !important;
}

.action-link:hover {
   background: #f8fafc !important;
   color: #0f172a !important;
   border-color: #94a3b8 !important;
   box-shadow: 0 2px 4px rgba(15, 23, 42, 0.08) !important;
}

.action-link:hover i {
   color: #0f172a !important;
}

.action-link.remove-data:hover,
.action-link.item-danger:hover {
   background: #fef2f2 !important;
   color: #dc2626 !important;
   border-color: #fca5a5 !important;
}

.action-link.remove-data:hover i,
.action-link.item-danger:hover i {
   color: #dc2626 !important;
}

/* Fixed Bottom Toolbar (Clean Footer Container) */
.box-footer-toolbar {
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding: 14px 22px;
   background: #fafbfc;
   border-top: 1px solid #e9edf2;
   border-bottom-left-radius: 8px;
   border-bottom-right-radius: 8px;
   flex-wrap: wrap;
   gap: 12px;
}

.toolbar-controls-left {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 10px;
}

.bulk-group {
   display: flex;
   align-items: center;
   gap: 6px;
}

.filter-group {
   display: flex;
   align-items: center;
   gap: 6px;
   flex-wrap: wrap;
}

.toolbar-divider {
   width: 1px;
   height: 22px;
   background-color: #e2e8f0;
   margin: 0 4px;
}

/* Consistent Control Heights & Borders */
.box-footer-toolbar .form-control {
   height: 34px !important;
   border-radius: 4px !important;
   font-size: 13px !important;
   border: 1px solid #cbd5e1 !important;
   background-color: #ffffff !important;
   box-shadow: none !important;
   padding: 6px 10px !important;
}

.box-footer-toolbar .form-control:focus {
   border-color: #00a65a !important;
}

.box-footer-toolbar select.form-control,
.box-footer-toolbar select {
   -webkit-appearance: none !important;
   -moz-appearance: none !important;
   appearance: none !important;
   background-color: #ffffff !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
   background-repeat: no-repeat !important;
   background-position: right 14px center !important;
   background-size: 11px !important;
   padding-right: 34px !important;
   padding-left: 12px !important;
   cursor: pointer !important;
}

.box-footer-toolbar select.form-control:focus,
.box-footer-toolbar select:focus {
   border-color: #00a65a !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2300a65a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
}

.box-footer-toolbar .btn-apply {
   height: 34px !important;
   padding: 0 14px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #334155 !important;
}

.box-footer-toolbar .btn-apply:hover {
   background: #f1f5f9 !important;
}

.box-footer-toolbar .btn-filter-submit {
   height: 34px !important;
   padding: 0 14px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   background: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
}

.box-footer-toolbar .btn-filter-submit:hover {
   background: #008d4c !important;
}

.box-footer-toolbar .btn-reset {
   height: 34px !important;
   width: 34px !important;
   padding: 0 !important;
   display: inline-flex !important;
   align-items: center !important;
   justify-content: center !important;
   border-radius: 4px !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #64748b !important;
}

.box-footer-toolbar .btn-reset:hover {
   background: #f1f5f9 !important;
   color: #334155 !important;
}

/* Pagination container */
.toolbar-controls-right {
   display: flex;
   align-items: center;
}

.toolbar-controls-right .pagination {
   margin: 0 !important;
}

.toolbar-controls-right .pagination > li > a,
.toolbar-controls-right .pagination > li > span {
   border-radius: 4px !important;
   margin: 0 2px !important;
   padding: 6px 12px !important;
   font-size: 12px !important;
   border: 1px solid #e2e8f0 !important;
}

.toolbar-controls-right .pagination > .active > a,
.toolbar-controls-right .pagination > .active > span {
   background-color: #00a65a !important;
   border-color: #00a65a !important;
   color: #fff !important;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('tiktok_categories') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_categories') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row" >
      <div class="col-md-12">
         <div class="box box-tiktok-categories">
            <div class="box-body" style="padding: 0;">
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment -->
                  <div class="widget-user-header" style="padding: 22px 25px;">
                     <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
                        <div class="widget-user-image" style="width: 52px; height: 52px; margin-right: 18px; float: none; display: flex; align-items: center;">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar" style="width: 52px; height: 52px; border-radius: 50%; float: none; display: block;">
                        </div>
                        <div class="header-titles" style="margin-left: 0;">
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_categories') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              <?= cclang('list_all', [cclang('tiktok_categories')]); ?> 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_categories_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <a class="btn btn-top-action" id="btn_sync" style="width: 34px !important; padding: 0 !important; justify-content: center !important;" href="<?= site_url('administrator/tiktok_categories/sync'); ?>" title="Tarik Data Kategori dari TikTok Shop">
                           <i class="fa fa-refresh"></i>
                        </a>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_categories" id="form_tiktok_categories" action="<?= base_url('administrator/tiktok_categories/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="min-width: 180px;">Nama Kategori</th>
                                 <th style="min-width: 160px;">ID Kategori TikTok</th>
                                 <th style="width: 140px;">Tipe Kategori</th>
                                 <th style="width: 120px; text-align: center;">Status Izin</th>
                                 <th style="width: 100px; text-align: right; padding-right: 20px;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_categories">
                              <?php foreach($tiktok_categoriess as $tiktok_categories): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_categories->id; ?>">
                                 </td>
                                 <td>
                                    <span style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                                       <i class="fa fa-folder-o" style="color: #64748b; font-size: 13px; margin-right: 8px;"></i><strong><?= _ent($tiktok_categories->local_name); ?></strong>
                                    </span>
                                 </td>
                                 <td>
                                    <span class="chip-id"><?= _ent($tiktok_categories->tiktok_category_id); ?></span>
                                 </td>
                                 <td><?= $tiktok_categories->is_leaf ? "Leaf Kategori" : "Induk Kategori"; ?></td>
                                 <td style="text-align: center; white-space: nowrap;">
                                     <?= strtoupper($tiktok_categories->permission_status) == "AVAILABLE" ? '<span class="label label-success">Tersedia</span>' : '<span class="label label-danger">Dibatasi</span>'; ?>
                                  </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                     <?= render_table_action([
                                        'view' => [
                                           'url' => site_url('administrator/tiktok_categories/view/' . $tiktok_categories->id),
                                           'permission' => 'tiktok_categories_view',
                                        ]
                                     ]); ?>
                                  </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_categories_counts == 0) :?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Data Kategori belum tersedia. Silakan klik tombol "Tarik Data Kategori".
                                 </td>
                              </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>

                     <!-- Bottom Toolbar with Precise Compact Gaps -->
                     <div class="box-footer-toolbar">
                        <div class="toolbar-controls-left">
                           <!-- Bulk Action -->
                           <div class="bulk-group">
                              <select class="form-control" name="bulk" id="bulk" style="width: 115px;">
                                 <option value="">Bulk</option>
                                 <option value="delete">Delete</option>
                              </select>
                              <button type="button" class="btn btn-apply" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>">
                                 <?= cclang('apply_button'); ?>
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>

                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>..." value="<?= $this->input->get('q'); ?>" style="width: 170px;">
                              
                              <select class="form-control" name="f" id="field" style="width: 160px;">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'local_name' ? 'selected' :''; ?> value="local_name">Nama Kategori</option>
                                 <option <?= $this->input->get('f') == 'tiktok_category_id' ? 'selected' :''; ?> value="tiktok_category_id">ID Kategori TikTok</option>
                                 <option <?= $this->input->get('f') == 'parent_category_id' ? 'selected' :''; ?> value="parent_category_id">ID Induk Kategori</option>
                                 <option <?= $this->input->get('f') == 'level' ? 'selected' :''; ?> value="level">Tingkat (Level)</option>
                                 <option <?= $this->input->get('f') == 'is_leaf' ? 'selected' :''; ?> value="is_leaf">Tipe Kategori</option>
                                 <option <?= $this->input->get('f') == 'permission_status' ? 'selected' :''; ?> value="permission_status">Status Izin</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_categories');?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>

                        <!-- Pagination on Right -->
                        <div class="toolbar-controls-right">
                           <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                              <?= $pagination; ?>
                           </div>
                        </div>
                     </div>

                  </form>
               </div>
               <!-- /.widget-user -->
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){
   
    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_tiktok_categories').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/tiktok_categories/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end apply click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

  }); /*end doc ready*/
</script>