<form action="{{ route('expenses.destroy', ['expense' => $expense->id]) }}" method="post" class="d-inline">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?')">Delete</button>
</form>
