<form id="sortForm" class="m-0">
    <label for="sortBy"> Sort By: </label>

    <div class="row m-0">
        <div class="col-6 px-0">
            <div class="input-group">
                <select id="sortBy" name="sortBy" class="form-select" onchange="submitSortForm(this)">
                    <option value="featured" @if ($sort_by == "featured") selected @endif> Featured </option>
                    <option value="price" @if ($sort_by == "price") selected @endif> Price </option>
                </select>
            </div>
        </div>

        <div class="col-6 px-2">
            <div class="input-group">
                <select id="sortOrder" name="sortOrder" class="form-select" onchange="submitSortForm(this)">
                    <option value="asc" @if ($sort_order == "asc") selected @endif> Ascending </option>
                    <option value="desc" @if ($sort_order == "desc") selected @endif> Descending </option>
                </select>
            </div>
        </div>
    </div>
</form>

<script>
    function submitSortForm(form) {

        const url = new URL(window.location.href);
        const params = new URLSearchParams(window.location.search);

        const sortBy = document.getElementById('sortBy').value;
        const sortOrder = document.getElementById('sortOrder').value;

        url.searchParams.set('sortBy', sortBy);
        url.searchParams.set('sortOrder', sortOrder);

        window.location.href = url.toString();
    };
</script>
