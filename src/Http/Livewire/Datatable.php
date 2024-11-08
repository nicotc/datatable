<?php

namespace Nicotc\Datatable\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;

use Nicotc\Datatable\Http\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;

class Datatable extends Component
{

  use WithPagination;


  protected $paginationTheme = 'bootstrap';

  public $hydrate;
  public $sortColumn = 'id';
  public $sortDirection = 'asc';
  public $searchTerm = '';
  public $itmesPerPage = 10;
  public $itemsSelecetPerPage = [10, 25, 50, 100];
  public $visibleColumns = [];
  public $search = [];
  public $create  = true;
  public $export = true;
  public $actions = [];
  public $createAction = [];
  public $modelDelete;
  public $downloadFileName = 'data.xlsx';


  // lissteners
  protected $listeners = ['delete', 'notify'];


  public function notify($message)
  {
    $this->getData();
  }

    public function updated(){
      $this->resetPage();
    }

    public function mount()
    {
      $this->visibleColumns = array_keys($this->getHeaders());
      $this->config();
    }


    public function sort($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        }
        $this->sortColumn = $column;
    }

    protected  function getData()
    {
        return $this->buildQuery()->paginate($this->itmesPerPage);

    }

    public function toggleColumnVisibility($column)
    {
        if (in_array($column, $this->visibleColumns)) {
            // Si la columna está visible, la eliminamos de las columnas visibles
            $this->visibleColumns = array_diff($this->visibleColumns, [$column]);
        } else {
            // Si la columna no está visible, la agregamos
            $this->visibleColumns[] = $column;
        }
    }


    public function render()
    {
      return view('datatable::livewire.datatable', [
          'data' => $this->getData(),
          'headers' => $this->getHeaders(),
      ]);
    }

    public function exportExcel(){


      $data = $this->buildQuery()->get()->toArray();
      $headers = $this->getHeaders();
      $headers  = array_keys($headers);

      return Excel::download(new ExcelExport($data, $headers), $this->downloadFileName);


    }

    public function delete($id)
    {
       $this->modelDelete::destroy($id);

    }



}
