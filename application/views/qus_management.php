<!-- Container for manage the questions -->
<div id="container" class="solid-border col-md-12">
    <h1 class="row">Add New Call</h1>
    <form id="qus-detail" method="POST" action="<?php echo base_url(); ?>qus_management/save_qus">  
        <div id="alert-message"></div>
        <div id="qus-container" class="col-md-12">             
        </div>
        <div class="clearfix">
            <div class="pull-right" id="add-new-qus-link">
                <a id="add-new-qus" title="Add New Question" href="javascript:void(0);" count-val="0">
                    <i class="fa fa-plus"> </i>
                    Add New Question
                </a>
            </div>
        </div>
        <div id="buttons" class="row">            
            <input type="submit" name="save" value="Save" class="btn btn-primary"/>
            <a id="cancel" title="Cancel" href="javascript:void(0);">Cancel</a>
        </div>
    </form>    
</div>
<script type="text/javascript">
    var qusType = '<?php echo json_encode($qusType); ?>';
</script>