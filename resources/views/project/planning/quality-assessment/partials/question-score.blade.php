<!-- Question Score -->
<div class="card">
    <div class="card-header">
        Question Score
    </div>
    <div class="card-body">
        <form>
            <!-- Question Selector -->
            <div class="form-group">
                <label for="question-id" class="form-control-label">Question</label>
                <select class="form-control" name="questionId" id="question-id">
                    @forelse($project->qualityAssessmentQuestions as $question)
                        <option value="{{ $question->id_question }}">{{ $question->description }}</option>
                    @empty
                    @endforelse
                </select>
            </div>

            <!-- Score Rule Name -->
            <div class="form-group">
                <label for="score-rule-name" class="form-control-label">Score Rule</label>
                <input class="form-control" type="text" id="score-rule-name">
            </div>

            <!-- Score Range Selector -->
            <div class="form-group">
                <label for="scoreRange" class="form-label">Score</label>
                <input type="range" class="form-range" id="scoreRange" min="0" max="100" step="5"
                    oninput="updateRangeValue(this.value)">
                <div class="d-flex justify-content-center">
                    <span id="currentScore">Score: 50%</span>
                </div>
            </div>
            <script>
                function updateRangeValue(value) {
                    document.getElementById("currentScore").textContent = "Score: " + value + "%";
                }
            </script>

            <!-- Score Rule Description -->
            <div class="form-group">
                <label for="score-rule-description" class="form-control-label">Description</label>
                <input class="form-control" type="text" id="score-rule-description">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>

    </div>
</div>
