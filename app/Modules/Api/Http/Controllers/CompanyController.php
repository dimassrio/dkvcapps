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

    public function postEntity(Request $request){
    	$results = $this->company->create(['ref_id'=>$request->input('ref_id'), 'name'=>$request->input('name')]);
    	return $this->response->item($results, $this->transformer);
    }

    public function deleteEntity($id, Request $request){
        $results = $this->company->find($id);
        $results->delete();
        return $this->response->noContent();
    }
}
