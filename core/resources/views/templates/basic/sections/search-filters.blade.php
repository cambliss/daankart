@push('styles')
<style>
  .custom-input,
  .custom-select {
    border: 1px solid orange;
    background-color: #fff7f0;
    color: #000;
  }

  .custom-input:focus,
  .custom-select:focus {
    box-shadow: none;
    border-color: darkorange;
  }

  .input-group-text {
    background-color: #fff7f0;
    border: 1px solid orange;
    border-right: none;
    color: orange;
  }

  .form-control.custom-input {
    border-left: none;
  }

  .form-control::placeholder {
    color: #999;
  }
</style>
@endpush

<form method="GET" action="{{ route('campaign.all') }}" id="search-filter-form">
  <div class="row g-2 align-items-center">
    <!-- Search Input with Icon Inside -->
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" name="search" class="form-control custom-input" placeholder="Search by Campaign/NGO" value="{{ request('search') }}">
      </div>
    </div>

    <!-- Location Dropdown -->
    <div class="col-md-3">
      <select class="form-select custom-select" name="location" onchange="document.getElementById('search-filter-form').submit();">
        <option value="">📍 Location (1)</option>
        <option value="hyderabad" {{ request('location') == 'hyderabad' ? 'selected' : '' }}>Hyderabad</option>
        <option value="karnataka" {{ request('location') == 'karnataka' ? 'selected' : '' }}>Karnataka</option>
      </select>
    </div>

    <!-- Type Dropdown -->
    <div class="col-md-3">
      <select class="form-select custom-select" name="type" onchange="document.getElementById('search-filter-form').submit();">
        <option value="">All Types</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ request('type') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
</form>

@push('scripts')
<script>
  // Optional: auto-submit on Enter inside the search box
  document.querySelector('input[name="search"]').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('search-filter-form').submit();
    }
  });
  document.querySelector('select[name="location"]').addEventListener('change', function () {
    document.getElementById('search-filter-form').submit();
  });
  document.querySelector('select[name="type"]').addEventListener('change', function () {
    document.getElementById('search-filter-form').submit();
  });
</script>
@endpush
