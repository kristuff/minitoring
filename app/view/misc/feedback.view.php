<section class="section">
<?php foreach ($this->feedbackNegatives as $feedback) { ?>
    <div class="alert" data-alert="error" role="alert">
        <button type="button" class="alert-close"><i class="fa fa-times"></i></button>
        <span><?php echo $feedback; ?></span>
    </div>
<?php } ?>
<?php foreach ($this->feedbackPositives as $feedback) { ?>
    <div class="alert" data-alert="success" role="alert">
        <button type="button" class="alert-close"><i class="fa fa-times"></i></button>
        <span><?php echo $feedback; ?></span>
    </div>
<?php } ?>
</section>
    