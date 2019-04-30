<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Text To Speech</title>            
        <link rel="stylesheet" type="text/css" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">   
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    </head>
    <body>              
        <div class="container main-content">
            <h1 class="text-center m-4 text-warning"><i class="fa fa-microphone text-secondary"></i> Text To Speech</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="alert alert-danger" id="error-message"></div>
                     @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                            {{ session()->forget('error') }}                       
                        </div>
                    @endif                                

                    <form id="text-to-speech-convert-form">
                        @csrf
                        <div class="form-group">
                           <label for="text">Enter Text</label>
                           <textarea required class="form-control" id="text" name="text" placeholder="Enter text for Your speech ..." rows="15">{{ old('text') }}</textarea>
                        </div>

                        <div class="form-group">
                           <label for="lan">Your Text Language</label>
                           <select required class="form-control" name="lan" id="lan">       
                                @foreach( config('textToSpeech.lan') as $key => $value )                         
                                    @if( $key == old('lan') )
                                        <option value="{{ $key }}" selected>{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                           </select>
                        </div>                                            
                        
                        <button type="submit" id="convert-speech" class="btn btn-info mb-2"><b>Convert</b> <i class="fa fa-refresh"></i></button>
                        <div class="text-center" id="speech-function"></div>

                    </form>
                </div>
            </div>
        </div>                                    
        <script src="{{ asset('js/jquery-3.3.1.min.js') }}" ></script>   
        <script src="{{ asset('js/jquery-validate/jquery.validate.min.js') }} "></script>
        <script src="{{ asset('js/jquery-validate/additional-methods.min.js') }} "></script>
        <script src="{{ asset('js/jquery-form/jquery.form.min.js') }} "></script>

        <script type="text/javascript">
            $(document).ready(function () {     
                var downloadFile;                
                $("#speech-function").html('');                          
                $("#error-message").hide();                          
                $("#download-speech").hide();

                $("#text-to-speech-convert-form").validate({
                    rules: {
                        text: { 
                            required: true,
                            maxlength: 500
                        }                                    
                    },
                    messages: {
                        text: {
                            required: "Please Enter Text",
                            maxlength: "Maximum 500 character."
                        }
                    }
                });        

                $(document).on('click', '#convert-speech', function(e){                                                                  
                    $("#error-message").hide();                          
                    
                    if($('#text-to-speech-convert-form').valid()) { 
                        e.preventDefault();                             
                        $('#convert-speech').attr("disabled", true);                                                                                
                        text = $('#text').val();
                        lan = $('#lan').val();
                       
                        $.ajax({              
                            url : "{{ route('text-to-speech-convert') }}",
                            type : "get",                                
                            data: {
                               text: text,                               
                               lan: lan                             
                            },                          
                            success:function(data) {                                                                          
                                                                                            
                                $('#convert-speech').attr("disabled", false);  
                                if( data["status"] == 200) {                                                                                                            
                                    downloadFile = data.responseText["download-file"];
                                    $("#download-speech").show(); 
                                    text = $('#text').val('');
                                    lan = $('#lan').prop("selectedIndex", 0);
                                    $("#speech-function").html('<audio controls><source src="'+ data.responseText["play-url"] +'" type="audio/mpeg"> Your browser does not support the audio element.</audio> ');
                                }   
                                else {
                                    $("#error-message").html(data["responseText"]).show(); 
                                }                               
                            },               
                            error:function(data){ 
                                $('#convert-speech').attr("disabled", false);                                
                                $("#error-message").html(data.responseJSON["message"]).show();                         
                                console.log(data);                               
                            }
                            
                        });   
                    }                                                                           
                });                                                 
            });
        </script>
    </body>
</html>
