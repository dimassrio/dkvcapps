<?php

namespace App\Transformer;
use App\Model\Company;
use League\Fractal;

class CompanyTransformer extends Fractal\TransformerAbstract
{
	public function transform(Company $company)
	{
		return [
			'id'     => (int) $company->id,
			'name'  => $company->name
		];
	}
}
