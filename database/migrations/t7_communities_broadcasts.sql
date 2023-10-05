-- Create the 'community_broadcasts' table
CREATE TABLE community_broadcasts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    community_id INT NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (community_id) REFERENCES communities(id),
    FOREIGN KEY (sender_id) REFERENCES users(id)
);