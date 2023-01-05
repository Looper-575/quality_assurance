              
                @foreach($sales as $data)
                    <option value="{{ $data->call_id }}"> {{ $data->account_number  }} - {{ $data->order_confirmation_number }} - {{ $data->order_number  }}</option>
                @endforeach
