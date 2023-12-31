<?php namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScaffoldSolution extends Command {
	protected $signature = 'advent:scaffold {day?} {year?}';

	public function handle() {
		$year = $this->argument('year') ?? Carbon::now()->year;
		$day = $this->argument('day') ?? Carbon::now()->day;

		$solutionPath = base_path('app/Solutions/Year' . $year . '/Day' . str($day)->padLeft(2, '0') . '.php');
		$testPath = base_path('tests/Unit/Solutions/Year' . $year . '/Day' . str($day)->padLeft(2, '0') . 'Test.php');

		$solutionStub = base_path('stubs/solution.stub');
		$testStub = base_path('stubs/test.stub');

		$this->copyStub($solutionPath, $solutionStub, $year, $day);
		$this->copyStub($testPath, $testStub, $year, $day);

		Artisan::call('advent:download', [
			'day' => $day,
			'year' => $year,
		]);
	}

	protected function copyStub($realPath, $stubPath, $year, $day) {
		if (!file_exists($realPath)) {
			$directory = str($realPath)
				->beforeLast('/')
				->value();

			if (!file_exists($directory)) {
				mkdir(
					$directory,
					recursive: true,
				);
			}

			file_put_contents(
				$realPath,
				str(file_get_contents($stubPath))
					->replace('{{ year }}', $year)
					->replace('{{ day }}', str($day)->padLeft(2, '0')->value())
					->value(),
			);
		}
	}
}
