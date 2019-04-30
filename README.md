<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

# Laravel Text To Speech Conveter

Laravel Text to speech converter is transformings the text into artificial human speech. Convert text into corresponding language speech. You can download that audio speech and play that audio speech.

- **Create a laravel project using composer**
		
		Laravel new text-to-speech-conveter

- **Create an account in VoiceRSS and get your API key from VoiceRSS**		
	
	[Create an account in VoiceRSS.](http://www.voicerss.org).<br />
	[Login in VoiceRSS.](http://www.voicerss.org/login.aspx).<br />
	[Get your API key](http://www.voicerss.org/personel/default.aspx). 

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
	
	[Click here](http://www.voicerss.org/downloads/voicerss_tts_php.zip.) to download VoiceRSS SDK. Extract zip and put the voicerss_tts.php file inside App\Library folder and rename to VoiceRss.php.

- **Convert Text Into Speech**
	
	Create a form which takes text and textual content language ( In which language you have written text ). 
	
	````
	use App\Library\VoiceRSS;
	// ...
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
	````

	[Click here](http://www.voicerss.org/api/documentation.aspx) to view VoiceRss Documen for know more about VoiceRSS.