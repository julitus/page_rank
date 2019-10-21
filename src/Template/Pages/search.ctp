<?php
    echo "\n";
    echo $this->Form->create();
    echo $this->Form->input('text', ['label' => false]);
    echo $this->Form->button(__('Buscar'));
    echo $this->Form->end();
?>

<?php debug($output); ?>