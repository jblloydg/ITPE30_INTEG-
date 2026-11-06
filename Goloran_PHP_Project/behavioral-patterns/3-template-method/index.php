
<?php

abstract class Report {
    final public function generateReport(): void {
        $this->generateHeader();

        $data = $this->retrieveData();

        $this->formatData($data);

        $this->generateFooter();
    }

    protected function generateHeader(): void {
        echo "===============================\n";
        echo "         " . $this->title() . "         \n";
        echo "===============================\n";
    }

    abstract protected function title(): string;

    abstract protected function retrieveData(): array;

    protected function formatData(array $data): void {
        foreach ($data as $key => $value) {
            echo "$key: $value\n";
        }
    }

    protected function generateFooter(): void {
        echo "===============================\n";
        echo "         End of Report         \n";
        echo "===============================\n";
    }
}

class StudentReport extends Report {
    protected function title(): string {
        return "Student Report";
    }

    protected function retrieveData(): array {
        return [
            "Student ID" => "2026-0001",
            "Name" => "John Doe",
            "Program" => "BSIT"
        ];
    }
}

class GradeReport extends Report {
    protected function title(): string {
        return "Grade Report";
    }

    protected function retrieveData(): array {
        return [
            "Student ID" => "2026-0001",
            "Grade" => "1.75"
        ];
    }
}

class EnrollmentReport extends Report {
    protected function title(): string {
        return "Enrollment Report";
    }

    protected function retrieveData(): array {
        return [
            "Student ID" => "2026-0001",
            "Status" => "Enrolled"
        ];
    }
}

// MAIN EXECUTION

foreach ([
    new StudentReport(),
    new GradeReport(),
    new EnrollmentReport()
] as $report) {

    $report->generateReport();

    echo "\n";
}

?>
