<div class="row">
    <div class="col-xs-12">
        <div class="box box-dttables box-info">
            <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                <thead>
                    <tr>
                        <th data-name="username">Username</th>
                        <th data-name="email">Email</th>
                        <th data-name="auth_group">Group</th>
                        <th data-name="action">Action</th>
                        <th data-name="desc">Desc</th>
                        <th data-name="created" data-searchable="false">Create Date</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!--/.box-dttables-->
    </div>
</div>
<!--/.row-->
<br/><br/>
<script type="text/javascript">
    list_dataTables('#dataTables-list', '<?php echo $url_data; ?>');
</script>
