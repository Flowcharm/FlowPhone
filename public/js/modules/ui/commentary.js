import { createStarRating } from '../../icons/star.js';

$id = $row['id'];
            $phone_id = $row['phone_id'];
            $user_id = $row['user_id'];
            $rating = $row['rating'];
            $review = $row['review'];
            $created_at = $row['created_at'];

export const createCommentary = ({ review, author = "Unknown User" }) => {
    const commentary = document.createElement('div');

    commentary.classList.add('commentary');

    const commentaryRow = document.createElement('div');
    commentaryRow.classList.add('commentary__row');

    const commentaryHeader = document.createElement('div');
    commentaryHeader.classList.add('commentary__header');

    const commentaryAuthor = document.createElement('h3');
    commentaryAuthor.classList.add('commentary__author');
    commentaryAuthor.textContent = author; // !

    const commentaryDate = document.createElement('span');

    const time = document.createElement('time');
    time.setAttribute('datetime', review.created_at);
    time.textContent = review.created_at; // !

    commentaryDate.appendChild(time);

    const commentaryStars = createStarRating({
        classContainer: 'commentary',
        rating: review.rating, // !
        showRating: false,
    });

    commentaryHeader.appendChild(commentaryAuthor);
    commentaryHeader.appendChild(commentaryDate);
    commentaryHeader.appendChild(commentaryStars);

    const commentaryReview = document.createElement('div');
    commentaryReview.classList.add('commentary__row');

    const reviewText = document.createElement('p');
    reviewText.classList.add('commentary__review');
    reviewText.textContent = review.review; // !

    commentaryReview.appendChild(reviewText);

    commentary.appendChild(commentaryRow);
    commentary.appendChild(commentaryHeader);
    commentary.appendChild(commentaryReview);

    return commentary;
}
