<div class="chat-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

<a href="#">
    <div class="pull-left">
        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    </div>
    <h4>Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
    <p>Why not buy a new awesome theme?</p>
</a>