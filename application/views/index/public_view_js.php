<style type="text/css">
    body {
        font-size:12px;
    }
    #m_tagsItem {
        background:#fff;
        position:absolute;
        top:0px;
        left:0px;
        overflow:hidden;
        width:250px;
        *width:250px;
        width:250px;
        padding:10px;
        border:1px solid #ccc;
        z-index:1000;
        display:none;
    }
    #m_tagsItem p {
        text-align:left;
        line-height:22px;
        padding:2px 0;
        margin:0;
        border:0;
    }
    #m_tagsItem span {
        font-weight:bold;
    }
    #m_tagsItem a {
        margin:0 5px;
    }

    #tagClose {
        font-size:12px;
        color:#888;
        cursor:pointer;
        position:absolute;
        top:2px;
        right:2px;
    }
</style>
<script type="text/javascript">
$(function(){
	$("#tagClose").click(function(){
	    $("#m_tagsItem").hide();
	})
})
</script>