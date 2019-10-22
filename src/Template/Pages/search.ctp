
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="login-content card">
                <div class="login-form">
                    
                    <?= $this->Form->create() ?>
                    	<?= $this->Form->input('text', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Buscar...', 'autofocus']) ?>
                    <?= $this->Form->end() ?>

                </div>
            </div>
        </div>

        <?php if(!empty($output)): ?>
	        <div class="col-lg-10">
	        	<div class="login-content card">

	        		<?php foreach ($output as $key => $out): ?>
	        			
	        			<?php if ($key % 2 == 0): ?>

	        				<div class="result-search">
	        					<div class="result-search-title"> <?= h($out) ?> </div>

	        			<?php else: ?>

	        					<div class="result-search-content"> <?= $this->Text->autoParagraph($out) ?> </div>
	        				</div>

	        			<?php endif; ?>

	        		<?php endforeach; ?>

	        	</div>
	        </div>
	    <?php endif; ?>

    </div>
</div>

<!--?php debug($output); ?-->