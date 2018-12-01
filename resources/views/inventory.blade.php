@extends('layouts.web')

@section('title', 'Inventory || BizWatch')

@section('content')
<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">

         @if(Session::has('error'))
                <div class="alert alert-danger" id="dismis">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                        {{Session::get('error')}}
                </div>

                @elseif(Session::has('success'))
                <div class="alert alert-success" id="dismis">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    {{Session::get('success')}}
                </div>
                @endif

             
             <div class="row">


                        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                          aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <label class="modal-title text-text-bold-600" id="myModalLabel33">Enter Inventory details</label>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="/inventory" method="post">
                                  <div class="modal-body">
                                    @csrf
                                    <label>Item name: </label>
                                    <div class="form-group">
                                      <input type="text" name="item_name" class="form-control">
                                    </div>
                                    <label>Unit Price: </label>
                                    <div class="form-group">
                                      <input type="text" name="unit_price" class="form-control">
                                    </div>
                                    <label>Quantity: </label>
                                    <div class="form-group">
                                      <input type="number" name="quantity"class="form-control">
                                    </div>
                                    <label>category: </label>
                                    <div class="form-group">
                                    <select class="custom-select" id="customSelect" name="category">
                                      <option selected="">food</option>
                                      <option>Clothing</option>
                                      <option>Accessories</option>
                                     
                                    </select>
                                    </div>
                                    <label>description: </label>
                                    <div class="form-group">
                                    <textarea class="form-control" id="basicTextarea" rows="3"></textarea>
                                    </div>
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                    value="close">
                                    <input type="submit" class="btn btn-outline-success btn-lg" value="Add Inventory">
                                  </div>
                                </form>
                              </div>
                            </div>
                        </div>

          <div id="recent-transactions" class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Inventory</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a class="btn btn-sm btn-danger text-white box-shadow-2 round btn-min-width pull-right"
                       data-toggle="modal"
                          data-target="#inlineForm">Add New Stock</a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
                <div class="table-responsive">
                  <table id="recent-orders" class="table table-hover table-xl mb-0">
                    <thead>
                      <tr>
                       
                        <th class="border-top-0">Stock Name</th>
                        <th class="border-top-0">Unit Price</th>
                        <th class="border-top-0">Categories</th>
                        <th class="border-top-0">In Stock</th>
                        <th class="border-top-0">Sold</th>
                        <th class="border-top-0">Total Price</th>
                        <th class="border-top-0">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                      <tr>
                        
                        <td class="text-truncate">
                          <span class="avatar avatar-xs">
                            <img class="box-shadow-2" src="../../../app-assets/images/portrait/small/avatar-s-4.png"
                            alt="avatar">
                          </span>
                          <span>{{$item->item_name}}</span>
                        </td>
                        <td class="text-truncate">₦ {{$item->unit_price}}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-outline-danger round">{{$item->category}}</button>
                        </td>
                        <td class="text-truncate">{{$item->quantity}}</td>
                        <td class="text-truncate">{{$item->sold}}</td>
                        <td class="text-truncate">₦ {{$item->quantity * $item->unit_price}}</td>
                        <td>
                        <button type="button" class="btn btn-success round" data-toggle="modal"
                          data-target="#inlineForm{{$item->id}}">Sell</button>
                        </td>


                           <div class="modal fade text-left" id="inlineForm{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                          aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <label class="modal-title text-text-bold-600" id="myModalLabel33">Enter Inventory details</label>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="/sell/{{$item->id}}" method="post">
                                  <div class="modal-body">
                                    @csrf
                                   
                                    <label>Quantity You want to sell: </label>
                                    <div class="form-group">
                                      <input type="number" name="sold"class="form-control">
                                    </div>
                                 
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal"
                                    value="close">
                                    <input type="submit" class="btn btn-outline-success btn-lg" value="Confirm Sale">
                                  </div>
                                </form>
                              </div>
                            </div>
                        </div>

                      </tr>
                   @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>


     </div>
    </div>
</div>

  @endsection
