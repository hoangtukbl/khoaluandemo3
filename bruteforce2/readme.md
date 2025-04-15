```bash
<!-- 
# Documentation for Docker Compose Usage

This section provides instructions on how to build and run the application using Docker Compose.

## Steps to Run the Application

1. Ensure Docker and Docker Compose are installed on your system.
2. Navigate to the project directory where the `docker-compose.yml` file is located.
3. Run the following command to build and start the containers:
    ```bash
    docker-compose up --build
    ```
    - The `--build` flag ensures that the images are rebuilt before starting the containers.

## Additional Notes

- If you encounter any issues, check the logs for detailed error messages.
- To stop the containers, use the following command:
    ```bash
    docker-compose down
    ```
- For detached mode (running in the background), add the `-d` flag:
    ```bash
    docker-compose up --build -d
    ```

-->
docker-compose up --build