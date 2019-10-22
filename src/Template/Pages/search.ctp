
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

        <?php if(!empty($results)): ?>
	        <div class="col-lg-10">
	        	<div class="login-content card">

	        		<?php foreach ($results as $key => $res): ?>

	        				<div class="result-search">
	        					<div class="result-search-title"> <?= h($res['title']) ?>  <span> ( <?= $res['rank'] ?> ) </span></div>
	        					<div class="result-search-content"> <?= $this->Text->autoParagraph($res['content']) ?> </div>
	        				</div>

	        		<?php endforeach; ?>

	        	</div>
	        </div>
	    <?php endif; ?>

    </div>
</div>

<!--?php debug($results); ?-->