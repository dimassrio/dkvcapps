<div class="form-group">
	<label for="title">Video Title</label>
	<input class="form-control" type="text" name="title[]" id="title"></input>
</div>
<div class="form-group">
	<label for="url">Video URL</label>
	<input class="form-control" type="text" name="url[]" id="url"></input>
</div>
<div class="form-group">
	<label for="cobrand">Co Brand</label>
	<select name="cobrand[]" id="cobrand" class="form-control">
		@foreach($option as $o)
			<option value="{{$o->id}}">{{$o->name}}</option>
		@endforeach
	</select>
</div>