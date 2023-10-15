<div class="modal fade" id="addAnnouncementModal{{$announcement->announcement_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit Announcement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="container">
              <div class="card mt-4">
                  <div class="card-header">
                      <h5>Edit Announcement Details</h5>
                  </div>
                  <div class="card-body">
                      <form method="POST" action="{{url('edit-announcement/'.$announcement->announcement_id)}}" enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                          <div class="row">
                              <input type="hidden" value="{{Auth::user()->id}}" name="id">
                              <div class="col-md-8 mb-3">
                                  <label class="form-label">Announcement Title</label>
                                  <input type="text" class="form-control" value="{{$announcement->announcement_title}}" name="announcement_title" required>
                                  @if($errors->has('announcement_title'))
                                  <span class="text-danger">{{ $errors->first('announcement_title') }}</span>
                                  @endif
                              </div>
                             
                              <div class="col-md-4 mb-3">
                                  <input type="hidden" name="announcement_date" value="{{now()->toDateTimeString()}}">
                                  <label class="form-label">Date</label>
                                  <input type="text" class="form-control" value="{{date('F d, Y', strtotime(now()->toDateTimeString()))}}" disabled>
                              </div>
                          </div>
                          

                          <div class="mb-3">
                              <div class="form-floating">
                                  <textarea class="form-control" name="announcement_content" id="floatingTextarea2" style="height: 100px">{{$announcement->announcement_content}}</textarea>
                                <label>Content</label>
                                  @if($errors->has('announcement_content'))
                                  <span class="text-danger">{{ $errors->first('announcement_content') }}</span>
                                  @endif
                                </div>
                          </div>

                          <div class="mb-3">
                            <label for="formFile" class="form-label">Current Attached Image: </label>
                            <img src="{{$announcement->announcement_img}}" alt="" style="height: 300px; width: auto">
                            <input type="hidden" name="announcement_image" value="{{$announcement->announcement_img}}">
                          </div>

                          <div class="mb-3">
                              <label for="formFile" class="form-label">Change Attached Image </label>
                              <input class="form-control" type="file" id="formFile" name="new_announcement_img">
                            </div>

                  
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success"><span class="btn-label"><i class="fas fa-save"></i></span> Save</button>
      </div>
      </div>
    </div>
  </div>
</form>
