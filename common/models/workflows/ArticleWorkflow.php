<?php

namespace common\models\workflows;

class ArticleWorkflow implements \raoul2000\workflow\source\file\IWorkflowDefinitionProvider
{
	
	public function getDefinition() {
		return [
			'initialStatusId' => 'aa-draft',
			'status' => [
				'aa-draft' => [
					'label' => 'Draft',
					'transition' => ['ba-pre-evaluate'],
					'metadata' => [
						'color' => 'danger',
						'start_at' => 'draft_at'
						//'icon' => 'fa fa-bell'
					]
				],
				//includes assign associate editor
				'ba-pre-evaluate' => [
					'label' => 'Pre-Evaluate',
					'transition' => ['ca-assign-reviewer', 'ra-reject', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'info',
						'start_at' => 'submit_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'ca-assign-reviewer' => [
					'label' => 'Assign Reviewer',
					'transition' => ['da-review', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'pre_evaluate_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'da-review' => [
					'label' => 'Review',
					'transition' => ['ea-recommend', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'success',
						'start_at' => 'asgn_reviewer_at'
						//'icon' => 'fa fa-bell' asgn_reviewer_at
					]
				],
				
				'ea-recommend' => [
					'label' => 'Recommendation',
					'transition' => ['fa-evaluate', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'success',
						'start_at' => 'review_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'fa-evaluate' => [
					'label' => 'Evaluate',
					'transition' => ['ga-response', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'info',
						'start_at' => 'recommend_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ga-response' => [
					'label' => 'Response to Author',
					'transition' => ['ha-correction', 'ra-reject', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'info',
						'start_at' => 'evaluate_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ha-correction' => [
					'label' => 'Correction',
					'transition' => ['ia-post-evaluate', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'primary',
						'start_at' => 'response_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ia-post-evaluate' => [
					'label' => 'Post Evaluate',
					'transition' => ['ja-galley-proof', 'ca-assign-reviewer', 'ra-reject',  'sa-withdraw-request'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'correction_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'ja-galley-proof' => [
					'label' => 'Galley Proof',
					'transition' => ['ka-assign-proof-reader', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'post_evaluate_at'
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ka-assign-proof-reader' => [
					'label' => 'Assign Proof Reader',	
					'transition' => ['la-proofread', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'asgn_profrdr_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'la-proofread' => [
					'label' => 'Proofreading',
					'transition' => ['ma-finalise',  'sa-withdraw-request'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'proofread_at'
						//'icon' => 'fa fa-bell'
					]
				],
				//finalise by the author
				'ma-finalise' => [
					'label' => 'Finalise',
					'transition' => ['oa-camera-ready', 'sa-withdraw-request'],
					'metadata' => [
						'color' => 'danger',
						'start_at' => 'finalise_at'
						//'icon' => 'fa fa-bell'
					]
				],
			
				
				'oa-camera-ready' => [
					'label' => 'Camera Ready',
					'transition' => ['pa-assign-journal'],
					'metadata' => [
						'color' => 'success',
						'start_at' => 'camera_ready_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'pa-assign-journal' => [
					'label' => 'Assign Journal',
					'transition' => ['qa-publish'],
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'assign_journal_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'qa-publish' => [
					'label' => 'Published',
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'journal_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'ra-reject' => [
					'label' => 'Reject',
					'metadata' => [
						'color' => 'warning',
						'start_at' => 'reject_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'sa-withdraw-request' => [
					'label' => 'Withdraw Request',
					'transition' => ['ta-withdraw', 'ia-post-evaluate','ha-correction','ga-response','fa-evaluate','ea-recommend','da-review','ca-assign-reviewer','ba-pre-evaluate'],
					'metadata' => [
						'color' => 'danger',
						'start_at' => 'withdraw_request_at'
						//'icon' => 'fa fa-bell'
					]
				],
				'ta-withdraw' => [
					'label' => 'Withdraw',
					'metadata' => [
						'color' => 'primary',
						'start_at' => 'withdraw_at'
						//'icon' => 'fa fa-bell'
					]
				],
				]
			]
			;
	}
}






?>