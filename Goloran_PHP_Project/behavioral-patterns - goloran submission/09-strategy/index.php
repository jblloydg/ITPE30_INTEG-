<?php
interface GradeStrategy { public function calculate(array $grades): float; }
class SimpleAverageStrategy implements GradeStrategy {
    public function calculate(array $grades): float { return array_sum($grades) / count($grades); }
}
class WeightedAverageStrategy implements GradeStrategy {
    public function calculate(array $grades): float { return $grades[0] * 0.3 + $grades[1] * 0.7; }
}
class TransmutedGradeStrategy implements GradeStrategy {
    public function calculate(array $grades): float { return min(100, (array_sum($grades) / count($grades)) * 1.05); }
}
class GradeCalculator {
    public function __construct(private GradeStrategy $strategy) {}
    public function setStrategy(GradeStrategy $strategy): void { $this->strategy = $strategy; }
    public function calculate(array $grades): float { return $this->strategy->calculate($grades); }
}
$calculator = new GradeCalculator(new SimpleAverageStrategy());
$grades = [85, 92];
echo 'Simple Average: ' . number_format($calculator->calculate($grades), 2) . "\n";
$calculator->setStrategy(new WeightedAverageStrategy());
echo 'Weighted Average: ' . number_format($calculator->calculate($grades), 2) . "\n";
$calculator->setStrategy(new TransmutedGradeStrategy());
echo 'Transmuted Grade: ' . number_format($calculator->calculate($grades), 2) . "\n";
