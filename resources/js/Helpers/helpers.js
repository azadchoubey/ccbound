export function formatDate(dateString) {
    // Parse the input date string (assuming it's in the format YYYY-MM-DD)
    const date = new Date(dateString);

    // Define an array of month abbreviations
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    // Extract the day, month, and year from the date object
    const day = String(date.getDate()).padStart(2, '0'); // Pad single digit days with a leading zero
    const month = months[date.getMonth()]; // Get the month abbreviation
    const year = date.getFullYear();

    // Format the date as DD-MMM-YYYY
    return `${day} ${month} ${year}`;
}

export function formatTime(dateString) {
    const date = new Date(dateString);

    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;

    return hours + ':' + minutes + ' ' + ampm;
}

export function currentDate() {
    // Parse the input date string (assuming it's in the format YYYY-MM-DD)
    const date = new Date();

    // Define an array of month abbreviations
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    // Extract the day, month, and year from the date object
    const day = String(date.getDate()).padStart(2, '0'); // Pad single digit days with a leading zero
    const month = months[date.getMonth()]; // Get the month abbreviation
    const year = date.getFullYear();

    // Format the date as DD-MMM-YYYY
    return `${day} ${month} ${year}`;
}
