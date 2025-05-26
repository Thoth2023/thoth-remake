@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
	@include('layouts.navbars.auth.topnav', ['title' => __('nav/topnav.edit')])
	<div class="card shadow-lg mx-4">
		<div class="container-fluid py-4">
			<p class="text-uppercase text-sm">{{ __('nav/topnav.edit')}}</p>
			<form method="POST" action="{{ route('projects.update', $project->id_project) }}" id="editProjectForm">
				@csrf
				@method('PUT')
				<div class="form-group">
					<label for="titleInput"> {{ __('project/edit.title')}}</label>
					<input name="title" value="{{ $project->title }}" type="text" class="form-control" id="titleInput"
						placeholder="{{ __('project/edit.enter_title') }}">
				</div>
				<!-- Container quill da descição, passando dados em HTML mas não vai até DB-->
				<div class="form-group">
					<label for="descriptionEditor">{{ __('project/edit.description')}}</label>
					<div id="descriptionEditor" class="form-control" style="height: 150px;">{!! $project->description !!}
					</div>
					<input type="hidden" name="description" id="descriptionInput">
				</div>
				<!-- Container quill do objectives | Quill funcional, passando dados em HTML mas não vai até DB-->
				<div class="form-group">
					<label for="objectivesEditor">{{ __('project/edit.objectives')}}</label>
					<div id="objectivesEditor" class="form-control" style="height: 150px;">{!! $project->objectives !!}
					</div>
					<input type="hidden" name="objectives" id="objectivesInput">
				</div>
				<div class="form-group">
					<label for="copy_planning">{{ __('project/edit.copy_planning') }}</label>
					<select class="form-control" id="copy_planning" name="copy_planning">
						@if(count($projects) > 1)
							<option value="none">{{ __('project/edit.none') }}</option>
							@foreach($projects as $project_option)
								@if (!($project_option->id_project == $project->id_project))
									<option value="{{ $project_option->id_project }}">{{ $project_option->title }}</option>
								@endif
							@endforeach
						@else
							@foreach($projects as $project_option)
								<option value="none">{{ $project_option->title }}</option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="feature_review" id="feature_review1"
						value="Systematic review">
					{{ old('feature_review') == 'Systematic review'}}</input>
					<label class="form-check-label" for="feature_review1">
						Systematic review
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="feature_review" id="feature_review2"
						value="Systematic review and Snowballing">
					{{ old('feature_review') == 'Systematic review and Snowballing'}}</input>
					<label class="form-check-label" for="feature_review2">
						Systematic review and Snowballing
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="feature_review" id="feature_review3"
						value="Snowballing">
					{{ old('feature_review') == 'Snowballing'}}</input>
					<label class="form-check-label" for="feature_review3">
						Snowballing
					</label>
				</div>

				<div class="d-flex align-items-center">
					<button type="submit" class="btn btn-primary btn-sm ms-auto">{{ __('project/edit.edit')}}</button>
				</div>
			</form>
			@include('layouts.footers.auth.footer')
		</div>
	</div>
@endsection

@push('scripts')
	<!-- Insee o js e o css do quill -->
	<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

	<script>

		// Initialize o Quill faz dois "construtores" para os dois editores
		document.addEventListener('DOMContentLoaded', function () {
			var descriptionEditor = new Quill('#descriptionEditor', {
				theme: 'snow'
			});
			var objectivesEditor = new Quill('#objectivesEditor', {
				theme: 'snow'
			});

			// tentativa de carregar o conteúdo do editor com o valor do campo hidden
			// atualmente não funciona, mas o valor do campo hidden é atualizado no submit
			// apesar de passar com dados não salva no BD
			document.getElementById('editProjectForm').addEventListener('submit', function () {
				document.getElementById('descriptionInput').value = descriptionEditor.root.innerHTML;
				document.getElementById('objectivesInput').value = objectivesEditor.root.innerHTML;
			});
		});
	</script>
@endpush