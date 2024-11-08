<div class="card">
  <div class="card-header">
      <div class="row mx-1">
          <div class="col-sm-12 col-md-3">
              <div class="dataTables_length"><label><select class="form-select" wire:model.change="itmesPerPage">
                          @foreach ($itemsSelecetPerPage as $value)
                              <option value="{{ $value }}">{{ $value }}</option>
                          @endforeach
                      </select></label></div>
          </div>
          <div class="col-sm-12 col-md-9">
              <div class="d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                  <div class="me-3">
                      <input type="text" wire:model.live="searchTerm" class="form-control" placeholder="Search..">
                  </div>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Columns
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($headers as $key => $value)
                            <li>
                                <label class="dropdown-item">
                                    <input type="checkbox" wire:click="toggleColumnVisibility('{{ $key }}')"
                                        @if (in_array($key, $visibleColumns)) checked @endif>
                                    {{ is_array($value) ? $value['label'] : $value }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($create)
                  <div class="dt-buttons">
                    @if ($createAction['isModal'] == true)
                      <button class="btn btn-primary" wire:click="$dispatch('{{ $createAction['event'] }}')">
                          <i class="{{ $createAction['icon'] }}"></i>
                          {{ $createAction['label'] }}
                      </button>
                    @else
                      <a href="{{ route($createAction['route']) }}" class="btn btn-primary">
                          <i class="{{ $createAction['icon'] }}"></i>
                          {{ $createAction['label'] }}
                      </a>
                    @endif

                  </div>
                @endif

                @if($export)
                  <div class="dt-buttons">
                      <button class="btn btn-primary" wire:click="exportExcel">
                          <i class="bx bx-export"></i>
                          {{ __('Export Excel') }}
                      </button>
                  </div>
                @endif


              </div>
          </div>
      </div>
  </div>

  <div class="card-body table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                  @foreach ($headers as $key => $value)
                  @if (in_array($key, $visibleColumns))
                      <th wire:click="sort('{{ $key }}')" style="cursor: pointer">
                          @if ($key == $sortColumn)
                              <span> {!! $sortDirection == 'asc' ? '&#8659' : '&#8657;' !!} </span>
                          @endif
                          {{ is_array($value) ? $value['label'] : $value }}
                      </th>
                  @endif
                  @endforeach
                  <th>{{ __('Actions') }}</th>
              </tr>
          </thead>
          <tbody>
            <tr>
            @foreach ($headers as $key => $value)
            @if (in_array($key, $visibleColumns))
              @if ($value['serchable'] == true)
                  <td>
                    <input type="text" wire:model.live="search.{{ $key }}" class="form-control" placeholder="Search..">
                  </td>
              @else
                  <td></td>
              @endif
            @endif
            @endforeach
            <td></td>
            </tr>

              @forelse ($data as $item)
                  <tr>
                      @foreach ($headers as $key => $value)
                      @if (in_array($key, $visibleColumns))
                          <td>{!! is_array($value) ? $value['func']($item->$key) : $item->$key !!}</td>
                      @endif
                      @endforeach
                      <td style="width: 5%">
                          <div class="dropdown">
                              {{-- <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"> --}}
                              <button class="btn p-0" data-bs-toggle="dropdown">
                                  <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">

                                @foreach ($actions as $key => $action )

                                  @if ($action['isModal'] == true)
                                    <button wire:click="$dispatch('{{ $action['event'] }}', { id: {{ $item->id }} })" class="dropdown-item">
                                        <i class="{{ $action['icon'] }} me-1"></i> {{  $key  }}
                                    </button>
                                  @else
                                    <a class="dropdown-item" href="{{ route($action['route'], $item->id) }}">
                                        <i class="{{ $action['icon'] }}  me-1"></i> {{  $key  }}
                                    </a>
                                  @endif

                                @endforeach


                              </div>
                          </div>
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="{{ count($headers) + 1 }}" class="text-center">{{ __('No data found') }}</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
      <div class="row mt-3">
          <div class="col-sm-12 col-md-6">
              <div>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries</div>
          </div>
          <div class="col-sm-12 col-md-6 d-flex justify-content-end">
              {{ $data->links() }}
          </div>
      </div>
  </div>
</div>
