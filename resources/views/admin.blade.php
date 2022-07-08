<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
          <th >id</th>
          <th >name</th>
          <th >email</th>
          <th >question</th>
          <th >Status</th>
          <th>edit</th>
        </tr>
      </thead>
    <tbody>
        
        @foreach($questions as $question)
              <tr>
                <td>{{$question->id}}</td>
                 <td>{{$question->name}}</td>
                 <td>{{$question->email}}</td>
                 <td>{{$question->question}}</td>
                 <form action="{{route("updateStatus")}}" >
                 <td>
                  <select class="form-select form-select-lg mb-3" name="status" style="height:30px; background-color:blue;color:white; border:0px">
                    <option value="1">{{$question->status}}</option>
                    <option value="2">{{($question->status)=="open"?"closed":"open"}}</option>
                  </select>
                  <input type="hidden" name="id" value="{{$question->id}}">
                </td>
                <td><input type="submit" class="btn btn-primary" value="save" ></td>
              </form>     
              </tr>
         @endforeach 
    </tbody>
    </table>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    </body>
</html>

