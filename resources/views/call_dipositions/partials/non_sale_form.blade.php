<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="form-check-label" for="customer_name"> Customer Name</label>
            <input  type="text" class="form-control" name="customer_name" id="customer_name">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="phone">Phone</label>
            <input required type="number" class="form-control" name="phone_number" id="phone_number">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-check-label" for="comments">Comments</label>
            <input required type="text" class="form-control" name="comments" id="comments">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="did"> DID</label>
            <select required class="form-control select2" name="did_id" id="did">
                <option value="" disabled selected >Select</option>
                @foreach($lead_did_data as $did_data)
                    <option value="{{ $did_data->did_id }}"> {{ $did_data->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="hidden" class="form-control" name="rec_id" id="rec_id" value="0">
</div>
