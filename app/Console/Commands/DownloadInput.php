<?php namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadInput extends Command {
	protected $signature = 'advent:download {day?} {year?}';

	/**
	 * Execute the console command.
	 */
	public function handle() {
		$username = env('GH_USERNAME');
		$repo = env('GH_REPO', 'laravel-advent');
		$session = env('AOC_SESSION');

		$year = $this->argument('year') ?? Carbon::now()->year;
		$day = $this->argument('day') ?? Carbon::now()->day;

		$input = Http::withHeader('Cookie', 'session=' . $session)
			->withUserAgent('github.com/' . $username . '/' . $repo)
			->get('https://adventofcode.com/' . $year . '/day/' . $day . '/input')
			->throw()
			->body();

		Storage::put(
			'inputs/' . $year . '/' . $day . '.txt',
			$input,
		);
	}
}
