# Hướng dẫn chạy project bằng Docker

## Yêu cầu
- Cài đặt Docker trên máy của bạn.

## Các bước thực hiện
1. **Build Docker Image**  
    Chạy lệnh sau trong thư mục dự án để build image:
    ```bash
    docker build -t khoaluandemo3 .
    ```

2. **Chạy Container**  
    Sử dụng lệnh sau để chạy container:
    ```bash
    docker run -p 8080:8080 khoaluandemo3
    ```
    - **8080**: Port của máy chủ sẽ được ánh xạ tới container.

3. **Truy cập ứng dụng**  
    Mở trình duyệt và truy cập vào địa chỉ:
    ```
    http://localhost:8080
    ```

## Kết quả chạy
- Ứng dụng sẽ hiển thị giao diện chính tại địa chỉ trên.
- Kiểm tra log của container để đảm bảo không có lỗi:
  ```bash
  docker logs <container_id>
  ```
