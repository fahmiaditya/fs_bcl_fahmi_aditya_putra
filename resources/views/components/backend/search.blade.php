<input type="text" name="url_first" id="url_first" value="{{ $route }}?page=1" hidden>
<div class="row">
    <div class="col-lg-12">
        <h5 class="card-title text-secondary text-center">FILTER DATA</h5>
        <div class="mb-2 search">
            <div class="input-group">
                <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian" />
                <span class="input-group-text"><i class="fe-search"></i></span>
            </div>
        </div>
        <div class="mb-2 sort_field">
            <select onchange="loadData('{{ $route }}?page=1')" class="form-control" id="sort_field" name="sort_field" data-toggle="select2" data-width="100%">
                <option selected value="created_at">Created</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 sort_asc">
                <div class="mb-2">
                    <select onchange="loadData('{{ $route }}?page=1')" class="form-control" id="sort_asc" name="sort_asc" data-toggle="select2" data-width="100%">
                        <option value="1">Asc</option>
                        <option selected value="0">Desc</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 per_page">
                <div class="mb-2">
                    <select onchange="loadData('{{ $route }}?page=1')" class="form-control" id="per_page" name="per_page" data-toggle="select2" data-width="100%">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>