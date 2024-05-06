<div class="card-group col-lg-6">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="table-responsive p-0" id="import_studies">
                <form action="{{ route('import.studies') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="selectDatabase">Selecione a Database:</label>
                        <select class="form-control" name="databaseId">
                            <option value="" disabled selected>
                                {{ __('project/planning.databases.form.select-placeholder') }}
                            </option>
                            @forelse ($databases as $database)
                                @if ($database->state == 'approved')
                                    <option value="{{ $database->id_database }}">
                                        {{ $database->name }}
                                    </option>
                                @endif
                            @empty
                                <option>{{ __('project/planning.databases.form.no-databases') }}</option>
                            @endforelse
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

