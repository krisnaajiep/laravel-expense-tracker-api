 <form class="d-flex" role="search">
     @include('expenses.includes.forms.inputs.hidden.search')
     <input class="form-control me-2" type="search" name="search" value="{{ request('search') }}" placeholder="Search"
         aria-label="Search">
     <button class="btn btn-outline-success me-5" type="submit">Search</button>
 </form>
