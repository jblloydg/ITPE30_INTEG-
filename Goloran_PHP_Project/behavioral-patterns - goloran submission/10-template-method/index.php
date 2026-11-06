<?php
abstract class Report {
    final public function generateReport(): void {
        $this->generateHeader(); $data = $this->retrieveData(); $this->formatData($data); $this->generateFooter();
    }
    protected function generateHeader(): void { echo "========================\n" . $this->title() . "\n========================\n"; }
    abstract protected function title(): string;
    abstract protected function retrieveData(): array;
    protected function formatData(array $data): void { foreach ($data as $key => $value) echo "$key: $value\n"; }
    protected function generateFooter(): void { echo "========================\nEND OF REPORT\n========================\n"; }
}
class StudentReport extends Report {
    protected function title(): string { return 'STUDENT REPORT'; }
    protected function retrieveData(): array { return ['Student ID'=>'2026-001','Name'=>'Juan Dela Cruz','Program'=>'BSIT']; }
}
class GradeReport extends Report {
    protected function title(): string { return 'GRADE REPORT'; }
    protected function retrieveData(): array { return ['Student ID'=>'2026-001','Grade'=>'1.75']; }
}
class EnrollmentReport extends Report {
    protected function title(): string { return 'ENROLLMENT REPORT'; }
    protected function retrieveData(): array { return ['Student ID'=>'2026-001','Status'=>'Enrolled']; }
}
foreach ([new StudentReport(), new GradeReport(), new EnrollmentReport()] as $report) { $report->generateReport(); echo "\n"; }
