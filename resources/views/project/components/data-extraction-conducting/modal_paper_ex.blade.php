<div class="modal fade bd-example-modal-lg" id="modal_paper_ex" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<input type="hidden" id="id_paper_ex">
				<h5 class="modal-title" id="paper_title_ex">Title Paper</h5>
				<small id="paper_id_ex"></small>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="index_paper_ex">
				<div class="form-inline">
					<div class="col-md-6">
						<h6>Doi</h6><a class="float-right opt"><i class="fas fa-question-circle"></i></a>
						<a target="_blank" id="paper_doi_ex"><i class="fas fa-external-link-alt"></i></a>
					</div>
					<div class="col-md-6">
						<h6>URL</h6>
						<a target="_blank" id="paper_url_ex"><i class="fas fa-external-link-alt"></i></a>
					</div>
					<div class="col-md-6">
						<h6>Author</h6>
						<p id="paper_author_ex"></p>
					</div>
					<div class="col-md-2">
						<h6>Year</h6>
						<p id="paper_year_ex"></p>
					</div>
					<div class="col-md-4">
						<h6>Database</h6>
						<p id="paper_database_ex"></p>
					</div>
					<div id="paper_status_ex" class="col-md-12">
						<h6>Status Extraction</h6>
						<p id="text_ex"></p>
						<select class="form-control" id="edit_status_ex">
							<option value="Done">Done</option>
							<option value="To Do">To Do</option>
							<option value="Removed">Removed</option>
						</select>
					</div>
					</hr>
					<div class="col-md-12">
						<h6>Abstract</h6>
						<p id="paper_abstract_ex" </p>
					</div>
					<div class="col-md-12">
						<h6>Keywords</h6>
						<p id="paper_keywords_ex" </p>
					</div>
				</div>
				<hr>
				<div class="col-md-12" id="ex_analiese">
					<h6>Extraction Questions</h6>
					<div class="form-inline" id="extraction_questions">
						<!-- Aqui serão inseridas as perguntas de extração -->
					</div>
					<br>
					<hr>
				</div>
				<div class="col-md-12">
					<h6>Note</h6>
					<textarea id="paper_note_ex" class="form-control"></textarea>
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