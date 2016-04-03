<div class="row">
    <div class="col-lg-12">
        <div class="form-message">
            <?php 
            if (isset($form_message)) {
                echo $form_message;
            }
            ?>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $page_title; ?> Form
            </div>
            <div class="panel-body">
                <?php echo form_open($form_action, 'role="form"'); ?>
                    <div class="row">
                        <div class="col-lg-8">
                            <?php if ($locales): ?>
                            <div class="localization" role="tabpanel" id="tabster">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php foreach ($locales as $row => $local): ?>
                                    <li role="presentation" <?php echo ($row == 0) ? 'class="active"' : ''?>>
                                        <a href="#<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" aria-controls="<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>" role="tab" data-toggle="tab">
                                            <?php echo ucfirst($local['locale']); ?>
                                            <?php echo ($local['locale_status'] == 1) ? ' (Default)' : ''; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul><!-- Nav tabs -->
                                <!-- /.tab content -->
                                <div class="tab-content">
                                    <?php foreach ($locales as $row => $local) : ?>
                                    <div role="tabpanel" class="tab-pane fade <?php echo ($row == 0) ? 'in active' : ''; ?>" id="<?php echo $local['iso_2'].'-'.$local['id_localization']; ?>">
                                        <div class="form-group">
                                            <label for="title_<?php echo $local['iso_1']; ?>">Title (<?php echo ucfirst($local['locale']); ?>)</label>
                                            <input type="text" class="form-control <?php echo ($row == 0) ? 'seodef' : ''; ?>" name="locales[<?php echo $local['id_localization']; ?>][title]" id="title_<?php echo $local['iso_1']; ?>" value="<?php echo (isset($post['locales'][$local['id_localization']]['title'])) ? $post['locales'][$local['id_localization']]['title'] : ''; ?>"/>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div><!-- /.tab content -->
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="uri_path">SEO URL / SLUG</label>
                                <input type="text" class="form-control" name="uri_path" id="uri_path" value="<?php echo (isset($post['uri_path'])) ? $post['uri_path'] : ''; ?>" required="required"/>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:50px;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-danger" href="<?php echo $cancel_url; ?>">Cancel</a>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $(function() {
        <?php if (!isset($post['id_article_category'])): ?>
        $(".seodef").keyup(function() {
            $("#uri_path").val(convert_to_uri(this.value));
        });
        <?php endif; ?>
    });
</script>
