<?php

use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;

$show_author = false;
if(Todo::can('jeb-managing-editor')){



$status = $model->wfStatus;



?>

<style>
table.detail-view th {
    width:15%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute' => 'id',
				'label' => 'Manuscript No.',
				'value' => function($model){
					return $model->manuscriptNo();
				}
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			'title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authors;
				}
			],
			
			[
				'label' => 'Scope',
				'format' => 'html',
				'value' => function($model){
					return $model->scope->scope_name;
				}
			],
			'abstract:ntext',
			'keyword',
			[
				'attribute' => 'submit_at',
				'format' => 'datetime'
			],
			[
				'attribute' => 'submission_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			]
			,
			[
				'attribute' => 'pre_evaluate_by',
				'value' => function($model){
					$person = $model->preEvaluateBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			]
			,
			[
				'attribute' => 'pre_evaluate_at',
				'format' => 'datetime'
			],
			'pre_evaluate_note:ntext'
			,
			
			
			[
				'attribute' => 'review_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			],
			[
				'attribute' => 'associate_editor',
				'value' => function($model){
					$person = $model->associateEditor;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			[
				'label' => 'Reviewers',
				'format' => 'raw',
				'value' => function($model){
					$html = '';
					$reviewers = $model->articleReviewers;
					
					if($reviewers){
						$html .= '<table class="table table-bordered table-striped">
							<thead>
							<tr>
							<th>Reviewer Name<br />
							<i>(Reviewer\'s Field)</i></th>
							<th>Appoint At</th>
							<th>Uploaded File</th>
							 <th>Status / Recommended Disposition</th>
							<th class="text-center" style="width: 90px;">
								
							</th>
							</tr>
							</thead>
							<tbody class="container-items">';
						foreach($reviewers as $review){
							$html .= '<tr>
							<td>' . $review->user->fullname . '<br />
							<i>(' . $review->scope->scope_name . ') - '.$review->getInternalExternalText().'</i></td>
							<td>'.$review->created_at .'</td>
			
						
							<td>' . Upload::showFile($review, 'reviewed', 'review') . '</td>
							
							<td>' . $review->getStatusLabel() . '<br />
							';
							if($review->status == 20){
								$html .= ReviewForm::reviewOptions()[$review->review_option];
							}
							
							
							$html .= '
							</td>
							<td>
							';
						if($review->status == 20){
							$i =1;
							foreach(ReviewForm::find()->all() as $f){
							$quest = 'q_'.$i;
							$res = $review->{$quest};
							if($res == 9){
							$res = 'NA';
							}
							$html.= 'Q'.$i.'='. $res . ', ';
							$i++;
							}
						}
						
							
							
						$html .= '</td>
						</tr>';
							
						}
						$html .= '</tbody></table>';
					}else{
						$html .= 'No Reviewer Assigned';
					}

					
					
					return $html;
					
				}
			],
			
			[
				'attribute' => 'recommend_by',
				'value' => function($model){
					$person = $model->recommedBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'recommend_at',
			'recommend_note:ntext',
			[
				'attribute' => 'recommend_option',
				'value' => function($model){
					return $model->recommendOption;
				}
				
			],
			[
				'attribute' => 'evaluate_by',
				'value' => function($model){
					$person = $model->evaluateBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'evaluate_at',
			'evaluate_note:ntext',
			[
				'attribute' => 'evaluate_option',
				'value' => function($model){
					return $model->evaluateOption;
				}
				
			],
			[
				'attribute' => 'response_by',
				'value' => function($model){
					$person = $model->responseBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'response_at',
			'response_note:ntext',
			'correction_at',
			'correction_note:ntext',
			[
				'attribute' => 'correction_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->correction_file){
						return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'correction', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> CORRECTION FILE</a>';
					}
					
				}
			],
			[
				'attribute' => 'post_evaluate_by',
				'value' => function($model){
					$person = $model->evaluateBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'post_evaluate_at',
			[
				'attribute' => 'assisstant_editor',
				'value' => function($model){
					$person = $model->assistantEditor;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			[
				'attribute' => 'galley_proof_by',
				'value' => function($model){
					$person = $model->galleyProofBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'galley_proof_at',
			'galley_proof_note:ntext',
			[
				'attribute' => 'proof_reader',
				'value' => function($model){
					$person = $model->proof_reader;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			]
			,
			'asgn_profrdr_at',
			[
				'attribute' => 'asgn_profrdr_by',
				'value' => function($model){
					$person = $model->assignProofreaderBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'proofread_at',
			'proofread_note:ntext',
			[
				'attribute' => 'proofread_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->proofread_file){
						return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'correction', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> PROOFREAD FILE</a>';
					}
					
				}
			]
			,
			'finalise_at',
			[
				'attribute' => 'finalise_option',
				'label' => 'Finalise Option',
				'value' => function($model){
					return $model->finaliseOption;
				}
				
			],
			'finalise_note:ntext',
			[
				'attribute' => 'finalise_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->finalise_file){
						return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'finalise', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FINALISE FILE</a>';
					}
					
				}
			],
			[
				'attribute' => 'camera_ready_by',
				'value' => function($model){
					$person = $model->cameraReadyBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'camera_ready_at',
			'camera_ready_note:ntext',
			[
				'attribute' => 'cameraready_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->cameraready_file){
						return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'cameraready', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> CAMERA READY FILE</a>';
					}
					
				}
			],
			[
				'attribute' => 'reject_by',
				'value' => function($model){
					$person = $model->rejectBy;
					if($person){
						return $person->fullname;
					}else{
						return '';
					}
				}
			],
			'reject_at',
			'reject_note:ntext',
			'withdraw_at',
			'withdraw_note:ntext',
			
			
			

        ],
    ]) ;
	
}
	?>

