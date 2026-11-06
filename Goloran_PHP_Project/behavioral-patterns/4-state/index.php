
<?php

interface State {
    public function name(): string;
    public function enroll(Student $student): void;
}

class Student {
    public function __construct(private State $state) {}

    public function setState(State $state): void {
        $this->state = $state;
    }

    public function enroll(): void {
        echo "Current State: " . $this->state->name() . "\n";
        echo "Action: Enroll\n";
        $this->state->enroll($this);
        echo "\n";
    }
}

class ApplicantState implements State {
    public function name(): string {
        return "Applicant";
    }

    public function enroll(Student $student): void {
        echo "Student must complete pre-assessment first.\n";
    }
}

class PreAssessmentState implements State {
    public function name(): string {
        return "Pre-Assessed";
    }

    public function enroll(Student $student): void {
        echo "Student successfully enrolled.\n";
        $student->setState(new EnrolledState());
    }
}

class EnrolledState implements State {
    public function name(): string {
        return "Enrolled";
    }

    public function enroll(Student $student): void {
        echo "Student is already enrolled.\n";
    }
}

class DroppedState implements State {
    public function name(): string {
        return "Dropped";
    }

    public function enroll(Student $student): void {
        echo "Student needs re-admission.\n";
    }
}

class GraduatedState implements State {
    public function name(): string {
        return "Graduated";
    }

    public function enroll(Student $student): void {
        echo "Student has already graduated.\n";
    }
}

// MAIN EXECUTION

$student = new Student(new ApplicantState());

$student->enroll();

$student->setState(new PreAssessmentState());
$student->enroll();

$student->enroll();

?>