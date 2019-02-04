ALTER TABLE member ADD facebook_id VARCHAR(255) NOT NULL DEFAULT '';
ALTER TABLE member ADD google_id VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE member ADD INDEX facebook_ind(facebook_id);
ALTER TABLE member ADD INDEX google_ind(google_id);
