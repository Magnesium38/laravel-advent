<?php namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RunSolution extends Command {
	protected $signature = 'advent:run {day?} {year?}';

	public function handle() {
		$year = $this->argument('year') ?? Carbon::now()->year;
		$day = $this->argument('day') ?? Carbon::now()->day;

		$input = Storage::get('inputs/' . $year . '/' . $day . '.txt');

		$start = Carbon::now();

		$pt1 = ['App\\Solutions\\Year2023\\Day01', 'pt1']($input) ?? 0;
		$pt2 = ['App\\Solutions\\Year2023\\Day01', 'pt2']($input) ?? 0;

		$end = Carbon::now();

		$this->info('Part one: ' . $pt1);
		$this->info('Part two: ' . $pt2);
		$this->info('Duration: ' . $end->diffInMilliseconds($start) . 'ms');
	}
}
