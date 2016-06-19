<?php

namespace App\Modules\Api\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformer\CompanyTransformer;
use App\Model\Company;
class CompanyController extends ApiController
{
	protected $transformer;
	protected $company;
	public function __construct(Company $company, CompanyTransformer $transformer){
		$this->company = $company;
		$this->transformer = $transformer;
	}
    public function getAll(Request $request){
    	$results = $this->company->all();

    	return $this->response->collection($results, $this->transformer);
    }

    public function getEntity($id, Request $request){
    	$results = $this->company->find($id);
    	return $this->response->item($results, $this->transformer);
    }
}
