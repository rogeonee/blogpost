CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author_id INT NOT NULL,
  picture VARCHAR(255),
  tags VARCHAR(255),
  post_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(userId)
);

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  post_id INT NOT NULL,
  comment_text TEXT NOT NULL,
  time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(userId),
);

INSERT INTO comments (user_id, post_id, comment_text) VALUES
(2, 1, 'I visited that same spot a few months ago and absolutely loved it. The views were breathtaking!'),
(2, 1, 'Thanks for sharing this recommendation. I\'ve been looking for a new hiking spot to try out, and this sounds perfect.'),
(1, 1, 'I\'ve been going to that spot for years and it never gets old. Glad to hear that others are discovering it too!');

INSERT INTO comments (user_id, post_id, comment_text) VALUES
(1, 2, 'I\'ve read a few of these and agree that they were fantastic. I\'ll have to check out the others on your list!'),
(1, 2, 'Thanks for sharing your favorites. I\'ve been looking for some new books to read and this list is super helpful.'),
(2, 2, 'I actually didn\'t enjoy a few of these books, but I\'m glad you found them enjoyable!');

INSERT INTO users (email, name, password, gender) VALUES
('johndoe@example.com', 'John Doe', 'password123', 'Male'),
('janesmith@example.com', 'Jane Smith', 'securepassword', 'Female'),
('bobsmith@example.com', 'Bob Smith', '12345', 'Male');
