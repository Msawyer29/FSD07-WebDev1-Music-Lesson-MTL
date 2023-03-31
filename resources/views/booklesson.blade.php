<style>
    #lesson-form-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1rem;
    }
    #lesson-form-container select {
        margin: 0.5rem 0;
        padding: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #ccc;
        width: 100%;
        max-width: 20rem;
    }
    #lesson-form-container label {
        margin-right: 0.5rem;
    }
</style>

<div id="lesson-form-container">
    <label for="teacherName">Teacher Name:</label>
    <select id="teacherName" name="teacherId" required>
        <option value="">Select a teacher</option>
        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
        @endforeach
    </select>
    <input type="hidden" id="studentId" name="studentId" value="{{ Auth::user()->id }}">
    <label for="lessonType">Lesson Type:</label>
    <select id="lessonType" name="lessonType" required>
        <option value="">Select a lesson type</option>
        <option value="guitar">Guitar</option>
        <option value="bass">Bass</option>
        <option value="piano">Piano</option>
        <option value="vocal">Vocal</option>
    </select>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="">Select a status</option>
        <option value="available">Available</option>
        <option value="booked">Booked</option>
        <option value="cancelled">Cancelled</option>
    </select>
</div>

<form id="lesson-form" method="POST" action="{{ route('lessons.store') }}">
    @csrf
    <div>
        <label for="paymentConfirmation">Payment Confirmation:</label>
        <input type="checkbox" id="paymentConfirmation" name="paymentConfirmation">
    </div>
    <div>
        <button type="submit">Book Lesson</button>
    </div>
</form>