<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Tiktok_shops/add';
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
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('tiktok_shops') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_shops') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
      
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <?php is_allowed('tiktok_shops_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('tiktok_shops')]); ?>  (Ctrl+a)" href="<?=  site_url('administrator/tiktok_shops/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', [cclang('tiktok_shops')]); ?></a>
                        <a class="btn btn-flat btn-success" id="btn_connect_tiktok" href="javascript:void(0);" title="Salin Authorize Link (TikTok Shop)" data-auth-url="<?= $auth_url ?? site_url('administrator/tiktok_shops/connect'); ?>"><i class="fa fa-copy"></i> Salin Authorize Link</a>
                        <?php }) ?>
                         <a class="btn btn-flat btn-success" id="btn_sync" title="Tarik Data Akun Toko dari TikTok Shop" href="<?= site_url('administrator/tiktok_shops/sync'); ?>"><i class="fa fa-refresh"></i></a>
                      </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username"><?= cclang('tiktok_shops') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('tiktok_shops')]); ?>  <i class="label bg-yellow"><?= $tiktok_shops_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_tiktok_shops" id="form_tiktok_shops" action="<?= base_url('administrator/tiktok_shops/index'); ?>">
                  

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr>
                           <th>
                              <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                           </th>
                           <th>Nama Toko</th>
                           <th>ID Toko</th>
                           <th>Region Toko</th>
                           <th>Masa Aktif Token</th>
                           <th>Status Toko</th>
                           <th>Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_tiktok_shops">
                     <?php foreach($tiktok_shopss as $tiktok_shops): ?>
                        <tr>
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_shops->id; ?>">
                           </td>
                                                       
                           <td><strong><?= _ent($tiktok_shops->shop_name); ?></strong></td> 
                           <td><?= _ent($tiktok_shops->shop_id); ?></td> 
                           <td><?= _ent($tiktok_shops->seller_base_region); ?></td> 
                           <td>
                              <?php
                              $expire_ts = (int) $tiktok_shops->access_token_expire_in;
                              if ($expire_ts > 0) {
                                  echo date('d/m/Y H:i', $expire_ts);
                                  if ($expire_ts < time()) {
                                      echo ' <span class="label label-danger">Expired</span>';
                                  }
                              } else {
                                  echo '-';
                              }
                              ?>
                           </td> 
                           <td>
                              <?php if ($tiktok_shops->is_active == 1): ?>
                                 <span class="label label-success">Aktif</span>
                              <?php else: ?>
                                 <span class="label label-danger">Nonaktif</span>
                              <?php endif; ?>
                           </td> 

                           <td width="220">
                              <?php is_allowed('tiktok_shops_view', function() use ($tiktok_shops){?>
                                 <a href="<?= site_url('administrator/tiktok_shops/view/' . $tiktok_shops->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?></a>
                              <?php }) ?>
                              <?php is_allowed('tiktok_shops_update', function() use ($tiktok_shops){?>
                                 <a href="<?= site_url('administrator/tiktok_shops/edit/' . $tiktok_shops->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                                 <a href="<?= site_url('administrator/tiktok_shops/refresh_token/' . $tiktok_shops->id); ?>" class="label-default" title="Refresh Access Token"><i class="fa fa-refresh"></i> Refresh Token</a>
                                 <a href="<?= site_url('administrator/tiktok_shops/sync_cipher/' . $tiktok_shops->id); ?>" class="label-default" title="Sinkronisasi Data Toko & Cipher"><i class="fa fa-exchange"></i> Sync Cipher</a>
                              <?php }) ?>
                              <?php is_allowed('tiktok_shops_delete', function() use ($tiktok_shops){?>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/tiktok_shops/delete/' . $tiktok_shops->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                              <?php }) ?>
                           </td>                        
                        </tr>
                      <?php endforeach; ?>
                      <?php if ($tiktok_shops_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Akun Toko data is not available
                           </td>
                         </tr>
                      <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
               <!-- /.widget-user -->
               <div class="row">
                  <div class="col-md-8">
                     <div class="col-sm-2 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <option value="">Bulk</option>
                           <option value="delete">Delete</option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'shop_name' ? 'selected' :''; ?> value="shop_name">Shop Name</option>
                           <option <?= $this->input->get('f') == 'shop_id' ? 'selected' :''; ?> value="shop_id">Shop Id</option>
                           <option <?= $this->input->get('f') == 'seller_base_region' ? 'selected' :''; ?> value="seller_base_region">Seller Base Region</option>
                           <option <?= $this->input->get('f') == 'is_active' ? 'selected' :''; ?> value="is_active">Is Active</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_shops');?>" title="<?= cclang('reset_filter'); ?>">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>                  
                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                        <?= $pagination; ?>
                     </div>
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->
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
      var serialize_bulk = $('#form_tiktok_shops').serialize();

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
               document.location.href = BASE_URL + '/administrator/tiktok_shops/delete?' + serialize_bulk;      
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


    // Copy Authorize Link
    $('#btn_connect_tiktok').on('click', function(e) {
        e.preventDefault();
        var authUrl = $(this).attr('data-auth-url') || '<?= site_url("administrator/tiktok_shops/connect"); ?>';
        var btn = $(this);
        var originalHtml = btn.html();

        function copySuccess() {
            btn.html('<i class="fa fa-check"></i> Link Tersalin!').addClass('btn-primary').removeClass('btn-success');
            setTimeout(function() {
                btn.html(originalHtml).addClass('btn-success').removeClass('btn-primary');
            }, 2500);

            if (typeof swal === 'function') {
                swal({
                    title: "Berhasil Disalin!",
                    text: "Authorize link berhasil disalin ke clipboard.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: true
                });
            } else if (typeof toastr !== 'undefined') {
                toastr.success('Authorize link berhasil disalin!');
            } else {
                alert('Authorize link berhasil disalin!');
            }
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(authUrl).then(function() {
                copySuccess();
            }).catch(function() {
                fallbackCopy(authUrl);
            });
        } else {
            fallbackCopy(authUrl);
        }

        function fallbackCopy(text) {
            var tempInput = document.createElement("textarea");
            tempInput.style.position = "fixed";
            tempInput.style.left = "-9999px";
            tempInput.style.top = "-9999px";
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.focus();
            tempInput.select();
            try {
                var successful = document.execCommand('copy');
                if (successful) {
                    copySuccess();
                } else {
                    prompt('Silakan salin authorize link di bawah ini:', text);
                }
            } catch (err) {
                prompt('Silakan salin authorize link di bawah ini:', text);
            }
            document.body.removeChild(tempInput);
        }
    });

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