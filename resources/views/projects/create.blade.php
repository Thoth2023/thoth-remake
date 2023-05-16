@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="container-fluid py-4">
            <p class="text-uppercase text-sm">Create Project</p>
            <form>
              <div class="form-group">
                <label for="titleInput">Title</label>
                <input type="text" class="form-control" id="titleInput" placeholder="Enter the title">
              </div>
              <div class="form-group">
                <label for="descriptionTextarea">Description</label>
                <textarea class="form-control" id="descriptionTextarea" rows="3" placeholder="Enter the description"></textarea>
              </div>
              <div class="form-group">
                <label for="objectivesTextarea">Objectives</label>
                <textarea class="form-control" id="objectivesTextarea" rows="3" placeholder="Enter the objectives"></textarea>
              </div>
              <div class="form-group">
                <label for="copyPlanningSelect">Copy Planning</label>
                <select class="form-control" id="copyPlanningSelect">
                  <option>Option 1</option>
                  <option>Option 2</option>
                  <option>Option 3</option>
                  <option>Option 4</option>
                  <option>Option 5</option>
                </select>
              </div>
            <div class="d-flex align-items-center">
              <button type="submit" class="btn btn-primary btn-sm ms-auto">Create</button>
            </div>
            </form>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection
