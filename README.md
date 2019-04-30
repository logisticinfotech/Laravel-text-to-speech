<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Laravel Text To Speech Conveter

Laravel Text to speech converter is transformings the text into artificial human speech. Convert text into corresponding language speech. You can download that audio speech and play that audio speech.

- **Create a laravel project using composer**
		Laravel new text-to-speech-conveter

- **Create an account in VoiceRSS and get your API key from VoiceRSS**
		Create an account in VoiceRSS. [Click here to register in VoiceRSS](http://www.voicerss.org).
		Login in VoiceRSS. [Click here to login](http://www.voicerss.org/login.aspx).
		[Click here to get your API key](http://www.voicerss.org/personel/default.aspx). 

- **Environment File Set your API Key**
		VOICE_RSS_API_KEY=your_api_key
	

- **Filesystem Configuration**
		In config/filesystems.php add following code for creating snapshot disk on which all snapshots will be saved. You can change the driver and root values. 
			```
			// ...
			'disks' => [
		        ...
		        'speeches' => [
		            'driver' => 'local',
		            'root' => storage_path('app/public/speeches'),
		        ],
		        ...
		    ],
			// ... 
			```

- **Create A Library For VoiceRSS**
		Create a form which takes text and textual content language ( In which language you have written text ).


- **Create A Controller Which Convert Text Into Speech**
		

- **Create A Controller Which Convert Text Into Speech**
		```
		use App\Library\VoiceRSS;
		…
		try {					
			$tts = new VoiceRSS;
			$voice = $tts->speech([
			    'key' => env('VOICE_RSS_API_KEY'),
			    'hl' =>  $request->lan,
			    'src' => $request->text,
			    'r' => '0',
			    'c' => 'mp3',
			    'f' => '44khz_16bit_stereo',
			    'ssml' => 'false',
			    'b64' => 'false'
			]);					
			$filename = Str::uuid().'.mp3';
			if( empty($voice["error"]) ) {		
				$rawData = $voice["response"];					
				if (!File::exists(storage_path('app/public/speeches')))
				{
					Storage::makeDirectory(public_path('storage/speeches'));
				}
				Storage::disk('speeches')->put($filename, $rawData);
				$speechFilelink =  asset('storage/speeches/'.$filename);							   		                 
			   	$urls["play-url"] = $speechFilelink;		   	
			   	$urls["download-file"] = $filename;			   
			   	$data = array('status' => 200, 'responseText' => $urls);
	          	return response()->json($data);		
			}
	   		$data = array('status' => 400, 'responseText' => "Please try again!");
           	return response()->json($data);     
		} 
		catch (SitemapParserException $e) {
		    	$data = array('status' => 400, 'responseText' => $e->getMessage());
            	return response()->json($data);
		} 		
		```

		Using voiceRss Library create the VoiceRSS instance( $tts = new VoiceRSS ). Using this instance generate speech. Pass variables key, hl, src,  r,  c, f, ssml, and b64 as array formate. [Click Here](http://www.voicerss.org/api/documentation.aspx) to view VoiceRss Documen for know more about VoiceRSS.