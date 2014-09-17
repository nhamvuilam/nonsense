<span class="error_message">
    Error System!
</span>
<a href="/">Return home</a>
<?php 
if(APPLICATION_ENV !='production'){
?>
<div style="display: block; width: 100%; float: left; text-align: left;">
        <h3>Exception information:</h3>
        <p> <b>Message:</b> <?php echo $this->exception->getMessage(); ?> </p>
        <h3>Stack trace:</h3>
        <pre><?php echo $this->exception->getTraceAsString(); ?></pre>
        <h3>Request Parameters:</h3>
        <pre><?php print_r($this->request->getParams()); ?></pre>
</div>
<?php }?>