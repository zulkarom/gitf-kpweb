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
						//'icon' => 'fa fa-bell'
					]
				],
				'ba-pre-evaluate' => [
					'label' => 'Pre-Evaluate',
					'transition' => ['ca-assign-reviewer', 'ra-reject'],
					'metadata' => [
						'color' => 'info',
						//'icon' => 'fa fa-bell'
					]
				],
				'ca-assign-reviewer' => [
					'label' => 'Assign Reviewer',
					'transition' => ['da-review'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'da-review' => [
					'label' => 'Review',
					'transition' => ['ea-recommend'],
					'metadata' => [
						'color' => 'success',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ea-recommend' => [
					'label' => 'Recommendation',
					'transition' => ['fa-evaluate'],
					'metadata' => [
						'color' => 'success',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'fa-evaluate' => [
					'label' => 'Evaluate',
					'transition' => ['ga-response'],
					'metadata' => [
						'color' => 'info',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ga-response' => [
					'label' => 'Response to Author',
					'transition' => ['ha-correction', 'ra-reject'],
					'metadata' => [
						'color' => 'info',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ha-correction' => [
					'label' => 'Correction',
					'transition' => ['ia-post-evaluate'],
					'metadata' => [
						'color' => 'primary',
						//'icon' => 'fa fa-bell'
					]
				],
				
				'ia-post-evaluate' => [
					'label' => 'Post Evaluate',
					'transition' => ['ja-galley-proof', 'ca-assign-reviewer', 'ra-reject'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'ja-galley-proof' => [
					'label' => 'Galley Proof',
					'transition' => ['ka-finalise'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'ka-finalise' => [
					'label' => 'Finalise',
					'transition' => ['la-assign-proof-reader', 'na-post-finalise'],
					'metadata' => [
						'color' => 'danger',
						//'icon' => 'fa fa-bell'
					]
				],
				'la-assign-proof-reader' => [
					'label' => 'Assign Proof Reader',
					'transition' => ['ma-proofread'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'na-post-finalise' => [
					'label' => 'Post Finalise',
					'transition' => ['ma-proofread'],
					'metadata' => [
						'color' => 'primary',
						//'icon' => 'fa fa-bell'
					]
				],
				'ma-proofread' => [
					'label' => 'Proofreading',
					'transition' => ['oa-camera-ready'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'oa-camera-ready' => [
					'label' => 'Camera Ready',
					'transition' => ['pa-assign-journal'],
					'metadata' => [
						'color' => 'success',
						//'icon' => 'fa fa-bell'
					]
				],
				'pa-assign-journal' => [
					'label' => 'Assign Journal',
					'transition' => ['qa-publish'],
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'qa-publish' => [
					'label' => 'Published',
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				'ra-reject' => [
					'label' => 'Reject',
					'metadata' => [
						'color' => 'warning',
						//'icon' => 'fa fa-bell'
					]
				],
				]
			]
			;
	}
}






?>