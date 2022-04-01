<?php 
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
  
class PaginationController extends Controller
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function index()
    {
        $args = \App\Custom\DataDemo::getDataForm();
        $array_form = array();
        foreach ($args as $data) {
            if($data['id'] == Auth::id() ) {
                foreach ($data['form_details'] as $data_form ) {
                    foreach ($data_form['form_version'] as $form_version) { 
                        array_push($array_form, $form_version);
                    }
                }
            }
        }
  
        $data = $this->paginate($array_form);
   
        return view('paginate', compact('data'));
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = ['123'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage), 
            $items->count(), 
            $perPage, 
            $page, 
            $options);
    }
}