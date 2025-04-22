<div class="modal fade bd-example-modal-lg" id="modal_paper_ex" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<input type="hidden" id="id_paper_ex">
				<h5 class="modal-title" id="paper_title_ex">
					{{ translationConducting('data-extraction.modal_paper_ex.title') }}
				</h5>
				<small id="paper_id_ex"></small>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_paper_ex">
				<div class="form-inline">
					<div class="col-md-6">
						<div>
							<h6>DOI</h6>
							<a class="float-right opt"><i class="fas fa-question-circle"></i></a>
							<a target="_blank" id="paper_doi_ex"><i class="fas fa-external-link-alt"></i></a>
						</div>
						<a href="#" id="paper_doi_ex"></a></i></a>
					</div>
					<div class="col-md-6">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.url') }}</h6>
						<a target="_blank" id="paper_url_ex"><i class="fas fa-external-link-alt"></i></a>
					</div>
					<div class="col-md-12 mt-3">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.export') }}</h6>
						<div>
							<a href="#" id="export_csv"><i class="fas fa-file-csv fa-2x"></i> CSV</a>
							<a href="#" id="export_xml"><i class="fas fa-file-code fa-2x"></i> XML</a>
							<a href="#" id="export_pdf"><i class="fas fa-file-pdf fa-2x"></i> PDF</a>
							<a href="#" id="export_print"><i class="fas fa-print fa-2x"></i> Imprimir</a>
						</div>
					</div>
					<div class="col-md-6">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.author') }}</h6>
						<p id="paper_author_ex"></p>
					</div>
					<div class="col-md-2">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.year') }}</h6>
						<p id="paper_year_ex"></p>
					</div>
					<div class="col-md-4">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.database') }}</h6>
						<p id="paper_database_ex"></p>
					</div>
					<div id="paper_status_ex" class="col-md-12">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.status.status-extraction') }}</h6>
						<select class="form-control" id="edit_status_ex">
							<option value="Done">
								{{ translationConducting('data-extraction.modal_paper_ex.status.done') }}
							</option>
							<option value="To Do">
								{{ translationConducting('data-extraction.modal_paper_ex.status.to_do') }}
							</option>
							<option value="Removed">
								{{ translationConducting('data-extraction.modal_paper_ex.status.removed') }}
							</option>
						</select>
					</div>
					</hr>
					<div class="col-md-12 mt-3">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.abstract') }}</h6>
						<p id="paper_abstract_ex"></p>
					</div>
					<div class="col-md-12">
						<h6>{{ translationConducting('data-extraction.modal_paper_ex.keywords') }}</h6>
						<p id="paper_keywords_ex"></p>
					</div>
				</div>
				<hr>
				<div class="col-md-12" id="ex_analiese">
					<h6>{{ translationConducting('data-extraction.modal_paper_ex.extraction_questions') }}</h6>
					<div class="form-inline" id="extraction_questions">
						<!-- Aqui serão inseridas as perguntas de extração -->
					</div>
					<br>
					<hr>
				</div>
				<div class="col-md-12">
					<h6>{{ translationConducting('data-extraction.modal_paper_ex.notes') }}</h6>
					<textarea id="paper_note_ex" class="form-control"></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-sm btn-view-paper">
						{{ translationConducting('data-extraction.modal_paper_ex.save') }}
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// Passe as perguntas de extração do PHP para JavaScript
	let questions = {!! json_encode($dataExtractionQuestions) !!};

	// Função para exibir as perguntas de extração
	function showQuestions() {
		let container = document.getElementById('extraction_questions');
		container.innerHTML = ''; // Limpa o conteúdo existente

		questions.forEach(function (question) {
			let div = document.createElement('div');
			if (question.type == '1') { // Text
				div.innerHTML = `
                    <div class="form-group">
                    <label for=${question.id_de}>${question.id} - ${question.description}</label>
                    <textarea id=${question.id_de} class="form-control" required></textarea>
                </div>
                `;
			} else if (question.type == '2') { //Multiple Choice
				let checkboxesHTML = `<label for=${question.id_de}>${question.id} - ${question.description}</label>`
				checkboxesHTML += question.options.map(option => `
				<div class="form-check">
					<input type="checkbox" class="form-check-input" name="question_${question.id}" value="${option}">
					<label class="form-check-label">${option}</label>
				</div>`).join('');

				div.innerHTML += checkboxesHTML;
			} else { // Pick One
				let radioHTML = `<label for=${question.id_de}>${question.id} - ${question.description}</label>`
				radioHTML += question.options.map(option => `
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="question_${question.id}" id="question_${question.id}_${option.replace(/\s/g, '')}" value="${option}">
                    <label class="form-check-label" for="question_${question.id}_${option.replace(/\s/g, '')}">${option}</label>
                </div>`).join('');
				div.innerHTML += radioHTML;
			}

			container.appendChild(div);
		});
	}
	// Chama a função showQuestions ao carregar a página
	document.addEventListener('DOMContentLoaded', function () {
		showQuestions();
	});
</script>
