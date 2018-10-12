<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-amazon-checkout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary">
                    <i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb["href"]; ?>"><?php echo $breadcrumb["text"]; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-payment" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="cubepay_url"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_cubepay_url; ?>"><?php echo $entry_url; ?>：</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="cubepay_url" id="cubepay_url" value="<?php echo ($cubepay_url)?$cubepay_url:" https://api.cubepay.io"?>" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="cubepay_client_id"><span data-toggle="tooltip" title="<?php echo $text_client_id?>"><?php echo $entry_payment_client_id?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="cubepay_client_id" id="cubepay_client_id" value="<?php echo $cubepay_client_id?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="cubepay_client_secret"><span data-toggle="tooltip" title="<?php echo $text_client_secret?>"><?php echo $entry_payment_client_secret; ?></span></label>
                        <div class="col-sm-10">
                            <input type="text" name="cubepay_client_secret" value="<?php echo $cubepay_client_secret ?>" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $text_only_support_one_currency?>"><?php echo $entry_fiat?></span></label>
                        <div class="col-sm-10">
                            <select name="cubepay_fiat" id="input-status" class="form-control">
                                <?php foreach($fiats as $fiat){?>
                                <option value="<?php echo $fiat["id"] ?>" <?php if ($fiat["id"] == $cubepay_fiat ) echo 'selected="selected"' ?>><?php echo $fiat["name"]?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="cubepay_status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="cubepay_status" id="cubepay_status" class="form-control">
                                <?php if($cubepay_status) {?>
                                <option value="1" selected="selected"><?php echo $text_enabled ?></option>
                                <option value="0"><?php echo $text_disabled?></option>
                                <?php }else{ ?>
                                <option value="1"><?php echo $text_enabled?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="cubepay_sort_order" value="<?php echo ($cubepay_sort_order)?$cubepay_sort_order:1 ; ?>" class="form-control" id="input-sort-order"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>